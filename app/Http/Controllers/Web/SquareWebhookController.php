<?php

namespace App\Http\Controllers\Web;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SquareWebhookController extends Controller
{
    /**
     * Handle incoming Square webhooks
     * Make sure this route is NOT protected by CSRF middleware
     * Add to routes: Route::post('/square-webhook', [SquareWebhookController::class, 'handleWebhook'])->withoutMiddleware('csrf');
     */
    public function handleWebhook(Request $request)
    {
        Log::info('Square Webhook Received', [
            'event_type' => $request->input('type'),
            'event_id' => $request->input('id'),
            'data' => $request->input('data')
        ]);

        $eventType = $request->input('type');
        $data = $request->input('data');

        // Always return 200 to acknowledge receipt (Square will retry if we don't)
        if (!$eventType || !$data) {
            Log::warning('Invalid webhook format');
            return response()->json(['status' => 'received'], 200);
        }

        try {
            switch ($eventType) {
                case 'subscription.updated':
                    $this->handleSubscriptionUpdated($data);
                    break;

                case 'subscription.created':
                    $this->handleSubscriptionCreated($data);
                    break;

                case 'subscription.cancelled':
                    $this->handleSubscriptionCancelled($data);
                    break;

                case 'subscription.resumed':
                    $this->handleSubscriptionResumed($data);
                    break;

                case 'subscription.paused':
                    $this->handleSubscriptionPaused($data);
                    break;

                case 'subscription.action.failed':
                    $this->handleSubscriptionActionFailed($data);
                    break;

                default:
                    Log::info('Unhandled webhook event type: ' . $eventType);
            }
        } catch (\Exception $e) {
            Log::error('Error processing Square webhook', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }

        // Always return 200 - Square expects this
        return response()->json(['status' => 'received'], 200);
    }

    /**
     * Handle subscription.updated event
     * This fires when subscription details change
     */
    private function handleSubscriptionUpdated($data)
    {
        $object = $data['object'] ?? [];
        $subscription = $object['subscription'] ?? [];
        $subscriptionId = $subscription['id'] ?? null;

        if (!$subscriptionId) {
            Log::warning('No subscription ID in update event');
            return;
        }

        $donation = Donation::where('subscription_id', $subscriptionId)->first();

        if (!$donation) {
            Log::warning('No donation found for subscription: ' . $subscriptionId);
            return;
        }

        $status = strtolower($subscription['status'] ?? 'unknown');
        $oldStatus = $donation->subscription_status;

        Log::info('Subscription Updated', [
            'subscription_id' => $subscriptionId,
            'old_status' => $oldStatus,
            'new_status' => $status,
            'charged_through_date' => $subscription['charged_through_date'] ?? null
        ]);

        // Update subscription record
        $donation->update([
            'subscription_status' => $status,
            'next_payment_date' => $subscription['charged_through_date'] ?? $donation->next_payment_date,
            'payment_response' => json_encode($subscription),
        ]);

        // Send email notification if status changed significantly
        if ($oldStatus !== $status) {
            $this->notifySubscriptionStatusChange($donation, $oldStatus, $status);
        }
    }

    /**
     * Handle subscription.created event
     */
    private function handleSubscriptionCreated($data)
    {
        $object = $data['object'] ?? [];
        $subscription = $object['subscription'] ?? [];
        $customerId = $subscription['customer_id'] ?? null;

        Log::info('Subscription Created', [
            'subscription_id' => $subscription['id'] ?? null,
            'customer_id' => $customerId
        ]);

        // Find donation by customer ID
        $donation = Donation::where('customer_id', $customerId)->first();

        if ($donation) {
            $donation->update([
                'subscription_id' => $subscription['id'],
                'subscription_status' => strtolower($subscription['status'] ?? 'active'),
                'payment_response' => json_encode($subscription),
            ]);

            Log::info('Updated donation with subscription ID', [
                'donation_id' => $donation->id,
                'subscription_id' => $subscription['id']
            ]);
        }
    }

    /**
     * Handle subscription.cancelled event
     */
    private function handleSubscriptionCancelled($data)
    {
        $object = $data['object'] ?? [];
        $subscription = $object['subscription'] ?? [];
        $subscriptionId = $subscription['id'] ?? null;

        if (!$subscriptionId) {
            return;
        }

        $donation = Donation::where('subscription_id', $subscriptionId)->first();

        if (!$donation) {
            Log::warning('No donation found for cancelled subscription: ' . $subscriptionId);
            return;
        }

        Log::info('Subscription Cancelled via Webhook', [
            'subscription_id' => $subscriptionId,
            'donation_id' => $donation->id
        ]);

        $donation->update([
            'subscription_status' => 'cancelled',
            'payment_response' => json_encode($subscription),
        ]);

        // Send cancellation email
        Mail::send('emails.subscription_cancelled', [
            'donation' => $donation,
            'reason' => 'Your subscription has been cancelled.'
        ], function ($message) use ($donation) {
            $message->to($donation->email)
                ->subject('Subscription Cancelled');
        });

        $this->notifySubscriptionStatusChange($donation, 'active', 'cancelled');
    }

    /**
     * Handle subscription.resumed event
     */
    private function handleSubscriptionResumed($data)
    {
        $object = $data['object'] ?? [];
        $subscription = $object['subscription'] ?? [];
        $subscriptionId = $subscription['id'] ?? null;

        if (!$subscriptionId) {
            return;
        }

        $donation = Donation::where('subscription_id', $subscriptionId)->first();

        if (!$donation) {
            Log::warning('No donation found for resumed subscription: ' . $subscriptionId);
            return;
        }

        Log::info('Subscription Resumed via Webhook', [
            'subscription_id' => $subscriptionId,
            'donation_id' => $donation->id
        ]);

        $donation->update([
            'subscription_status' => 'active',
            'next_payment_date' => $subscription['charged_through_date'] ?? null,
            'payment_response' => json_encode($subscription),
        ]);

        $this->notifySubscriptionStatusChange($donation, 'paused', 'active');
    }

    /**
     * Handle subscription.paused event
     */
    private function handleSubscriptionPaused($data)
    {
        $object = $data['object'] ?? [];
        $subscription = $object['subscription'] ?? [];
        $subscriptionId = $subscription['id'] ?? null;

        if (!$subscriptionId) {
            return;
        }

        $donation = Donation::where('subscription_id', $subscriptionId)->first();

        if (!$donation) {
            Log::warning('No donation found for paused subscription: ' . $subscriptionId);
            return;
        }

        Log::info('Subscription Paused via Webhook', [
            'subscription_id' => $subscriptionId,
            'donation_id' => $donation->id,
            'pause_date' => $subscription['pause_effective_date'] ?? null
        ]);

        $donation->update([
            'subscription_status' => 'paused',
            'payment_response' => json_encode($subscription),
        ]);

        $this->notifySubscriptionStatusChange($donation, 'active', 'paused');
    }

    /**
     * Handle subscription.action.failed event
     * This is important - handles failed payments, etc.
     */
    private function handleSubscriptionActionFailed($data)
    {
        $object = $data['object'] ?? [];
        $subscription = $object['subscription'] ?? [];
        $subscriptionId = $subscription['id'] ?? null;

        if (!$subscriptionId) {
            return;
        }

        $donation = Donation::where('subscription_id', $subscriptionId)->first();

        if (!$donation) {
            Log::warning('No donation found for failed subscription action: ' . $subscriptionId);
            return;
        }

        $error = $object['error'] ?? [];
        $errorMessage = $error['message'] ?? 'Unknown error';

        Log::error('Subscription Action Failed', [
            'subscription_id' => $subscriptionId,
            'donation_id' => $donation->id,
            'error' => $errorMessage,
            'code' => $error['code'] ?? null
        ]);

        // Update donation with failure info
        $donation->update([
            'payment_status' => 'failed',
            'payment_response' => json_encode([
                'error' => $errorMessage,
                'subscription' => $subscription
            ]),
        ]);

        // Send failure notification email
        Mail::send('emails.payment_failed', [
            'donation' => $donation,
            'error' => $errorMessage
        ], function ($message) use ($donation) {
            $message->to($donation->email)
                ->subject('Payment Failed - Action Required');
        });

        Log::info('Sent payment failure notification to ' . $donation->email);
    }

    /**
     * Send email notification when subscription status changes
     */
    private function notifySubscriptionStatusChange($donation, $oldStatus, $newStatus)
    {
        $statusMessages = [
            'active' => 'Your subscription is now active',
            'paused' => 'Your subscription has been paused',
            'cancelled' => 'Your subscription has been cancelled',
            'failed' => 'Your subscription has failed'
        ];

        $message = $statusMessages[$newStatus] ?? 'Your subscription status has changed';

        try {
            Mail::send('emails.subscription_status_change', [
                'donation' => $donation,
                'old_status' => ucfirst($oldStatus),
                'new_status' => ucfirst($newStatus),
                'message' => $message
            ], function ($mailMessage) use ($donation, $newStatus) {
                $mailMessage->to($donation->email)
                    ->subject('Subscription ' . ucfirst($newStatus));
            });

            Log::info('Status change notification sent', [
                'donation_id' => $donation->id,
                'email' => $donation->email,
                'old_status' => $oldStatus,
                'new_status' => $newStatus
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send status change notification', [
                'error' => $e->getMessage()
            ]);
        }
    }
}