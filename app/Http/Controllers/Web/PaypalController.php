<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Role;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaypalController extends Controller
{
    private function getBaseUrl()
    {
        return env('PAYPAL_MODE') === 'live'
            ? 'https://api-m.paypal.com'
            : 'https://api-m.sandbox.paypal.com';
    }

    private function getAccessToken()
    {
        $mode = env('PAYPAL_MODE', 'sandbox');
        
        if ($mode === 'sandbox') {
            $clientId = env('PAYPAL_SANDBOX_CLIENT_ID');
            $secret = env('PAYPAL_SANDBOX_CLIENT_SECRET');
        } else {
            $clientId = env('PAYPAL_LIVE_CLIENT_ID');
            $secret = env('PAYPAL_LIVE_CLIENT_SECRET');
        }

        if (!$clientId || !$secret) {
            \Log::error('PayPal credentials missing', [
                'mode' => $mode,
                'has_client_id' => !empty($clientId),
                'has_secret' => !empty($secret)
            ]);
            return null;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getBaseUrl() . "/v1/oauth2/token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "$clientId:$secret");
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Accept: application/json",
            "Accept-Language: en_US"
        ]);

        $result = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($result, true);
        return $json['access_token'] ?? null;
    }

    public function payment(Request $request)
    {
        try {
            $amount = $request->input('amount');
            $userId = $this->getOrCreateUser($request);

            $donation = Donation::create([
                'user_id' => $userId,
                'name'   => $request->input('name'),
                'email'  => $request->input('email'),
                'phone'  => $request->input('phone'),
                'amount' => $amount,
                'currency' => config('paypal.currency') ?? 'USD',
                'payment_method' => 'paypal',
                'status' => 'pending',
                'is_verified' => true,
            ]);

            $accessToken = $this->getAccessToken();
            
            $data = [
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('paypal.success', ['donation_id' => $donation->id]),
                    "cancel_url" => route('paypal.cancel', ['donation_id' => $donation->id]),
                    "brand_name" => "iPharmacy",
                    "shipping_preference" => "NO_SHIPPING",
                    "user_action" => "PAY_NOW",
                ],
                "purchase_units" => [[
                    "reference_id" => "DONATION_" . $donation->id,
                    "description" => "Donation to iPharmacy",
                    "amount" => [
                        "currency_code" => config('paypal.currency') ?? 'USD',
                        "value" => number_format($amount, 2, '.', '')
                    ]
                ]]
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->getBaseUrl() . "/v2/checkout/orders");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Content-Type: application/json",
                "Authorization: Bearer $accessToken"
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

            $result = curl_exec($ch);

            if (curl_errno($ch)) {
                throw new \Exception("cURL error: " . curl_error($ch));
            }

            curl_close($ch);

            $response = json_decode($result, true);
            
            if (isset($response['id']) && $response['status'] === 'CREATED') {
                foreach ($response['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        return redirect()->away($link['href']);
                    }
                }
            }

            throw new \Exception("PayPal order creation failed: " . json_encode($response));
        } catch (\Throwable $e) {
            \Log::error('PayPal Payment Error: ' . $e->getMessage());

            if (isset($donation)) {
                $donation->update(['status' => 'failed']);
            }

            return redirect()->route('paypal.cancel', ['donation_id' => $donation->id ?? null])
                ->with('error', 'Payment could not be processed. Please try again.');
        }
    }

    public function subscription(Request $request)
    {
        $userId = $this->getOrCreateUser($request);

        $donation = \App\Models\Donation::create([
            'user_id' => $userId,
            'name'   => $request->name,
            'email'  => $request->email,
            'phone'  => $request->phone,
            'amount' => $request->amount,
            'currency' => 'USD',
            'donation_type' => 'Donation_Monthly',
            'payment_method' => 'paypal',
            'payment_status' => 'pending',
        ]);

        $accessToken = $this->getAccessToken();
        
        if (!$accessToken) {
            return back()->with('error', 'Unable to get PayPal access token.');
        }

        $plan = \App\Models\Plan::where('amount', $request->amount)
            ->where('currency', 'USD')
            ->where('status', 'ACTIVE')
            ->first();

        if (!$plan) {
            $productData = [
                'name' => 'Donation Plan - ' . $request->amount,
                'description' => 'Monthly donation plan',
                'type' => 'SERVICE',
                'category' => 'CHARITY',
            ];

            $productResponse = $this->paypalPost("/v1/catalogs/products", $productData, $accessToken);
            $productId = $productResponse['id'] ?? null;
            if (!$productId) {
                return back()->with('error', 'Failed to create PayPal product.');
            }

            $planData = [
                'product_id' => $productId,
                'name' => 'Donation Plan - ' . $request->amount,
                'description' => 'Monthly recurring donation plan',
                'billing_cycles' => [[
                    'frequency' => ['interval_unit' => 'MONTH', 'interval_count' => 1],
                    'tenure_type' => 'REGULAR',
                    'sequence' => 1,
                    'total_cycles' => 0,
                    'pricing_scheme' => [
                        'fixed_price' => [
                            'value' => number_format($request->amount, 2, '.', ''),
                            'currency_code' => 'USD'
                        ]
                    ]
                ]],
                'payment_preferences' => [
                    'auto_bill_outstanding' => true,
                    'setup_fee' => ['value' => '0', 'currency_code' => 'USD'],
                    'setup_fee_failure_action' => 'CONTINUE',
                    'payment_failure_threshold' => 3
                ]
            ];

            $planResponse = $this->paypalPost("/v1/billing/plans", $planData, $accessToken);
            $planId = $planResponse['id'] ?? null;

            if (!$planId) {
                return back()->with('error', 'Failed to create PayPal plan.');
            }

            $plan = \App\Models\Plan::create([
                'name' => 'Donation Plan - ' . $request->amount,
                'description' => 'Monthly donation plan',
                'paypal_product_id' => $productId,
                'paypal_plan_id' => $planId,
                'interval_unit' => 'MONTH',
                'interval_count' => 1,
                'amount' => $request->amount,
                'currency' => 'USD',
                'status' => 'ACTIVE'
            ]);
        }

        $data = [
            "plan_id" => $plan->paypal_plan_id,
            "subscriber" => [
                "name" => ["given_name" => $donation->name],
                "email_address" => $donation->email
            ],
            "application_context" => [
                "brand_name" => "iPharmacy",
                "locale" => "en-US",
                "user_action" => "SUBSCRIBE_NOW",
                "return_url" => route('paypal.success', ['donation_id' => $donation->id]),
                "cancel_url" => route('paypal.cancel', ['donation_id' => $donation->id])
            ]
        ];

        $response = $this->paypalPost("/v1/billing/subscriptions", $data, $accessToken);

        $nextPaymentDate = Carbon::now()->addMonth();
        if (!empty($response['id'])) {
            $subscription = \App\Models\Subscription::create([
                'user_id' => $userId,
                'subscription_gateway_id' => $response['id'],
                'plan_id' => $plan->id,
                'status' => 'PENDING',
                'start_date' => now(),
            ]);

            $donation->update(['subscription_id' => $subscription->id]);

            foreach ($response['links'] ?? [] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }

        $donation->update(['payment_status' => 'failed']);
        return view('web.failed', ['donation' => $response])
            ->with('error', 'Payment not completed.');
    }

    public function success(Request $request)
    {
        $donation = \App\Models\Donation::findOrFail($request->donation_id);
        $accessToken = $this->getAccessToken();

        if ($request->query('token') && !$donation->subscription_id) {
            $orderId = $request->query('token');
            $response = $this->paypalPost("/v2/checkout/orders/{$orderId}/capture", null, $accessToken);

            if (($response['status'] ?? null) === 'COMPLETED') {
                $donation->update([
                    'payment_status' => 'success',
                    'transaction_id' => $orderId,
                    'payment_response' => json_encode($response)
                ]);

                return view('web.success', ['donation' => $response]);
            }

            $donation->update(['payment_status' => 'failed']);
            return view('web.failed', ['donation' => $response]);
        }

        if ($donation->subscription_id) {
            $subscription = \App\Models\Subscription::find($donation->subscription_id);
            $subId = $subscription->subscription_gateway_id;

            $details = $this->paypalGet("/v1/billing/subscriptions/{$subId}", $accessToken);

            if (($details['status'] ?? '') === 'ACTIVE') {
                $subscription->update([
                    'status' => 'ACTIVE',
                    'customer_id' => $details['subscriber']['payer_id'] ?? null,
                    'next_payment_date' => $details['billing_info']['next_billing_time'] ?? null,
                    'start_date' => $details['start_time'] ?? now(),
                ]);

                $donation->update([
                    'payment_status' => 'success',
                    'subscription_status' => 'active',
                    'next_payment_date' => $subscription->next_payment_date,
                    'transaction_id' => $details['id'] ?? null,
                    'payment_response' => json_encode($details),
                    'payment_method' => 'paypal',
                ]);

                return view('web.success', ['donation' => $details]);
            }
        }

        $donation->update(['payment_status' => 'failed']);
        return view('web.failed', ['donation' => []]);
    }

    public function cancel(Request $request)
    {
        if ($request->donation_id) {
            $donation = Donation::find($request->donation_id);
            if ($donation) $donation->update(['payment_status' => 'failed']);
        }

        return view('web.failed', ['donation' => $donation ?? null]);
    }

    // ==================== WEBHOOK IMPLEMENTATION ====================

    public function webhook(Request $request)
    {
        \Log::info('PayPal Webhook Received', [
            'headers' => $request->headers->all(),
            'body' => $request->all()
        ]);

        // Verify webhook signature
        if (!$this->verifyWebhookSignature($request)) {
            \Log::error('PayPal Webhook: Invalid signature');
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        $payload = $request->all();
        $eventType = $payload['event_type'] ?? null;

        try {
            switch ($eventType) {
                // One-time payment events
                case 'PAYMENT.CAPTURE.COMPLETED':
                    $this->handlePaymentCaptureCompleted($payload);
                    break;
                
                case 'PAYMENT.CAPTURE.DENIED':
                case 'PAYMENT.CAPTURE.REFUNDED':
                    $this->handlePaymentFailed($payload);
                    break;

                // Subscription events
                case 'BILLING.SUBSCRIPTION.CREATED':
                    $this->handleSubscriptionCreated($payload);
                    break;
                
                case 'BILLING.SUBSCRIPTION.ACTIVATED':
                    $this->handleSubscriptionActivated($payload);
                    break;
                
                case 'BILLING.SUBSCRIPTION.UPDATED':
                    $this->handleSubscriptionUpdated($payload);
                    break;
                
                case 'BILLING.SUBSCRIPTION.CANCELLED':
                    $this->handleSubscriptionCancelled($payload);
                    break;
                
                case 'BILLING.SUBSCRIPTION.SUSPENDED':
                    $this->handleSubscriptionSuspended($payload);
                    break;
                
                case 'BILLING.SUBSCRIPTION.PAYMENT.FAILED':
                    $this->handleSubscriptionPaymentFailed($payload);
                    break;
                
                case 'PAYMENT.SALE.COMPLETED':
                    $this->handleSubscriptionPaymentCompleted($payload);
                    break;

                default:
                    \Log::info('PayPal Webhook: Unhandled event type', ['type' => $eventType]);
            }

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            \Log::error('PayPal Webhook Error: ' . $e->getMessage(), [
                'event_type' => $eventType,
                'payload' => $payload
            ]);
            return response()->json(['error' => 'Webhook processing failed'], 500);
        }
    }

    private function verifyWebhookSignature(Request $request)
    {
        $webhookId = env('PAYPAL_WEBHOOK_ID');
        
        if (!$webhookId) {
            \Log::warning('PayPal Webhook ID not configured - skipping verification');
            return true; // For development only - REMOVE in production
        }

        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            \Log::error('Could not get access token for webhook verification');
            return false;
        }

        $headers = [
            'auth_algo' => $request->header('PAYPAL-AUTH-ALGO'),
            'cert_url' => $request->header('PAYPAL-CERT-URL'),
            'transmission_id' => $request->header('PAYPAL-TRANSMISSION-ID'),
            'transmission_sig' => $request->header('PAYPAL-TRANSMISSION-SIG'),
            'transmission_time' => $request->header('PAYPAL-TRANSMISSION-TIME'),
        ];

        $requestBody = $request->getContent();

        $verificationData = [
            'auth_algo' => $headers['auth_algo'],
            'cert_url' => $headers['cert_url'],
            'transmission_id' => $headers['transmission_id'],
            'transmission_sig' => $headers['transmission_sig'],
            'transmission_time' => $headers['transmission_time'],
            'webhook_id' => $webhookId,
            'webhook_event' => json_decode($requestBody, true)
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getBaseUrl() . "/v1/notifications/verify-webhook-signature");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer $accessToken"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($verificationData));
        
        $result = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($result, true);
        
        return ($response['verification_status'] ?? '') === 'SUCCESS';
    }

    // Handle one-time payment completed
    private function handlePaymentCaptureCompleted($payload)
    {
        $captureId = $payload['resource']['id'] ?? null;
        $orderId = $payload['resource']['supplementary_data']['related_ids']['order_id'] ?? null;
        
        \Log::info('Payment Capture Completed', [
            'capture_id' => $captureId,
            'order_id' => $orderId
        ]);

        $donation = Donation::where('transaction_id', $orderId)->first();
        
        if ($donation && $donation->payment_status !== 'success') {
            $donation->update([
                'payment_status' => 'success',
                'payment_response' => json_encode($payload)
            ]);
            
            $this->sendDonationConfirmationEmail($donation);
        }
    }

    private function handlePaymentFailed($payload)
    {
        $orderId = $payload['resource']['supplementary_data']['related_ids']['order_id'] ?? null;
        
        $donation = Donation::where('transaction_id', $orderId)->first();
        
        if ($donation) {
            $donation->update([
                'payment_status' => 'failed',
                'payment_response' => json_encode($payload)
            ]);
        }
    }

    private function handleSubscriptionCreated($payload)
    {
        $subscriptionId = $payload['resource']['id'] ?? null;
        
        \Log::info('Subscription Created', ['subscription_id' => $subscriptionId]);
        
        $subscription = \App\Models\Subscription::where('subscription_gateway_id', $subscriptionId)->first();
        
        if ($subscription) {
            $subscription->update([
                'status' => 'APPROVAL_PENDING',
            ]);
        }
    }

    private function handleSubscriptionActivated($payload)
    {
        $subscriptionId = $payload['resource']['id'] ?? null;
        $subscriberInfo = $payload['resource']['subscriber'] ?? [];
        $billingInfo = $payload['resource']['billing_info'] ?? [];
        
        \Log::info('Subscription Activated', ['subscription_id' => $subscriptionId]);
        
        $subscription = \App\Models\Subscription::where('subscription_gateway_id', $subscriptionId)->first();
        
        if ($subscription) {
            $subscription->update([
                'status' => 'ACTIVE',
                'customer_id' => $subscriberInfo['payer_id'] ?? null,
                'next_payment_date' => $billingInfo['next_billing_time'] ?? null,
                'start_date' => $payload['resource']['start_time'] ?? now(),
            ]);
            
            $donation = Donation::where('subscription_id', $subscription->id)->first();
            if ($donation) {
                $donation->update([
                    'payment_status' => 'success',
                    'subscription_status' => 'active',
                    'next_payment_date' => $billingInfo['next_billing_time'] ?? null,
                ]);
                
                $this->sendSubscriptionConfirmationEmail($donation, $subscription);
            }
        }
    }

    private function handleSubscriptionUpdated($payload)
    {
        $subscriptionId = $payload['resource']['id'] ?? null;
        
        $subscription = \App\Models\Subscription::where('subscription_gateway_id', $subscriptionId)->first();
        
        if ($subscription) {
            $subscription->update([
                'status' => $payload['resource']['status'] ?? $subscription->status,
            ]);
        }
    }

    private function handleSubscriptionCancelled($payload)
    {
        $subscriptionId = $payload['resource']['id'] ?? null;
        
        \Log::info('Subscription Cancelled', ['subscription_id' => $subscriptionId]);
        
        $subscription = \App\Models\Subscription::where('subscription_gateway_id', $subscriptionId)->first();
        
        if ($subscription) {
            $subscription->update([
                'status' => 'CANCELLED',
            ]);
            
            $donation = Donation::where('subscription_id', $subscription->id)->first();
            if ($donation) {
                $donation->update([
                    'subscription_status' => 'cancelled',
                ]);
                
                $this->sendSubscriptionCancellationEmail($donation);
            }
        }
    }

    private function handleSubscriptionSuspended($payload)
    {
        $subscriptionId = $payload['resource']['id'] ?? null;
        
        $subscription = \App\Models\Subscription::where('subscription_gateway_id', $subscriptionId)->first();
        
        if ($subscription) {
            $subscription->update([
                'status' => 'SUSPENDED',
            ]);
            
            $donation = Donation::where('subscription_id', $subscription->id)->first();
            if ($donation) {
                $donation->update([
                    'subscription_status' => 'paused',
                ]);
            }
        }
    }

    private function handleSubscriptionPaymentFailed($payload)
    {
        $subscriptionId = $payload['resource']['id'] ?? null;
        
        \Log::error('Subscription Payment Failed', [
            'subscription_id' => $subscriptionId,
            'payload' => $payload
        ]);
        
        $subscription = \App\Models\Subscription::where('subscription_gateway_id', $subscriptionId)->first();
        
        if ($subscription) {
            \App\Models\SubscriptionTransaction::create([
                'subscription_id' => $subscription->id,
                'transaction_id' => $payload['resource']['id'] ?? null,
                'amount' => $subscription->plan->amount ?? 0,
                'currency' => 'USD',
                'status' => 'failed',
                'payment_time' => now(),
                'payment_response' => json_encode($payload)
            ]);
            
            $donation = Donation::where('subscription_id', $subscription->id)->first();
            if ($donation) {
                $this->sendPaymentFailedEmail($donation);
            }
        }
    }

    private function handleSubscriptionPaymentCompleted($payload)
    {
        $subscriptionId = $payload['resource']['billing_agreement_id'] ?? null;
        $saleId = $payload['resource']['id'] ?? null;
        $amount = $payload['resource']['amount']['total'] ?? 0;
        
        \Log::info('Subscription Payment Completed', [
            'subscription_id' => $subscriptionId,
            'sale_id' => $saleId,
            'amount' => $amount
        ]);
        
        $subscription = \App\Models\Subscription::where('subscription_gateway_id', $subscriptionId)->first();
        
        if ($subscription) {
            \App\Models\SubscriptionTransaction::create([
                'subscription_id' => $subscription->id,
                'transaction_id' => $saleId,
                'amount' => $amount,
                'currency' => $payload['resource']['amount']['currency'] ?? 'USD',
                'status' => 'completed',
                'payment_time' => $payload['resource']['create_time'] ?? now(),
                'payment_response' => json_encode($payload)
            ]);
            
            $subscription->update([
                'next_payment_date' => Carbon::parse($subscription->next_payment_date)->addMonth(),
            ]);
            
            $donation = Donation::where('subscription_id', $subscription->id)->first();
            if ($donation) {
                $this->sendRecurringPaymentReceipt($donation, $amount, $saleId);
            }
        }
    }

    // Email notification methods
    private function sendDonationConfirmationEmail($donation)
    {
        try {
            \Mail::send('emails.donation_confirmation', [
                'name' => $donation->name,
                'amount' => '$'.$donation->amount,
                'transaction_id' => $donation->transaction_id
            ], function ($message) use ($donation) {
                $message->to($donation->email)
                    ->subject('Thank you for your donation - iPharmacy');
            });
        } catch (\Exception $e) {
            \Log::error('Failed to send donation confirmation email: ' . $e->getMessage());
        }
    }

    private function sendSubscriptionConfirmationEmail($donation, $subscription)
    {
        try {
            \Mail::send('emails.subscription_confirmation', [
                'name' => $donation->name,
                'amount' => '$'.$donation->amount,
                'next_payment_date' => $subscription->next_payment_date
            ], function ($message) use ($donation) {
                $message->to($donation->email)
                    ->subject('Monthly Subscription Confirmed - iPharmacy');
            });
        } catch (\Exception $e) {
            \Log::error('Failed to send subscription confirmation email: ' . $e->getMessage());
        }
    }

    private function sendSubscriptionCancellationEmail($donation)
    {
        try {
            \Mail::send('emails.subscription_cancelled', [
                'name' => $donation->name
            ], function ($message) use ($donation) {
                $message->to($donation->email)
                    ->subject('Subscription Cancelled - iPharmacy');
            });
        } catch (\Exception $e) {
            \Log::error('Failed to send cancellation email: ' . $e->getMessage());
        }
    }

    private function sendPaymentFailedEmail($donation)
    {
        try {
            \Mail::send('emails.payment_failed', [
                'name' => $donation->name,
                'amount' =>'$'. $donation->amount
            ], function ($message) use ($donation) {
                $message->to($donation->email)
                    ->subject('Payment Failed - iPharmacy');
            });
        } catch (\Exception $e) {
            \Log::error('Failed to send payment failed email: ' . $e->getMessage());
        }
    }

    private function sendRecurringPaymentReceipt($donation, $amount, $transactionId)
    {
        try {
            \Mail::send('emails.recurring_payment_receipt', [
                'name' => $donation->name,
                'amount' => '$'.$amount,
                'transaction_id' => $transactionId,
                'payment_date' => now()->format('F d, Y')
            ], function ($message) use ($donation) {
                $message->to($donation->email)
                    ->subject('Payment Receipt - iPharmacy Monthly Donation');
            });
        } catch (\Exception $e) {
            \Log::error('Failed to send payment receipt: ' . $e->getMessage());
        }
    }

    // ==================== END WEBHOOK IMPLEMENTATION ====================

    // Existing methods continue below...

    private function getOrCreateUser($request)
    {
        if (\Auth::check()) {
            return \Auth::id();
        }

        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user) {
            return $user->id;
        }

        $password = \Illuminate\Support\Str::random(10);

        $user = \App\Models\User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role_id' =>   Role::USER,
            'mobile'   => $request->phone,
            'password' => \Illuminate\Support\Facades\Hash::make($password),
            'status'   => 1,
            'is_verified' => true,
        ]);

        \Mail::send('emails.user_welcome', [
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $password,
        ], function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Welcome! Your account has been created');
        });

        return $user->id;
    }

    private function paypalGet($endpoint, $accessToken)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getBaseUrl() . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer $accessToken"
        ]);
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }

    private function paypalPost($endpoint, $data, $accessToken)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getBaseUrl() . $endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer $accessToken"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $response = json_decode($result, true) ?: [];
        $response['status_code'] = $httpCode;
        
        return $response;
    }

    public function pauseSubscription($donationId)
    {
        $donation = Donation::findOrFail($donationId);
        $subscription = $donation->subscription;
        $accessToken = $this->getAccessToken();

        if (!$subscription || !$subscription->subscription_gateway_id) {
            return response()->json(['success' => false, 'message' => 'Subscription not found']);
        }

        $paypalId = $subscription->subscription_gateway_id;
        
        $currentStatus = $this->paypalGet("/v1/billing/subscriptions/{$paypalId}", $accessToken);
        $status = strtoupper($currentStatus['status'] ?? '');
        
        if ($status === 'SUSPENDED') {
            $subscription->update(['status' => 'SUSPENDED']);
            $donation->update(['subscription_status' => 'paused']);
            return response()->json([
                'success' => false, 
                'message' => 'Subscription is already paused',
                'status' => 'suspended'
            ]);
        }
        
        if ($status !== 'ACTIVE') {
            return response()->json([
                'success' => false, 
                'message' => 'Only active subscriptions can be paused. Current status: ' . $status
            ]);
        }
        
        $data = ['reason' => 'User requested pause'];
        $response = $this->paypalPost("/v1/billing/subscriptions/{$paypalId}/suspend", $data, $accessToken);

        if (in_array($response['status_code'], [204, 200])) {
            $subscription->update(['status' => 'SUSPENDED']);
            $donation->update(['subscription_status' => 'paused']);
            
            return response()->json([
                'success' => true, 
                'message' => 'Subscription paused successfully',
                'status' => 'suspended'
            ]);
        }

        return response()->json([
            'success' => false, 
            'message' => $response['message'] ?? 'Failed to pause subscription',
            'error_details' => $response['details'] ?? null
        ]);
    }

    public function resumeSubscription($donationId)
    {
        $donation = Donation::findOrFail($donationId);
        $subscription = $donation->subscription;
        $accessToken = $this->getAccessToken();

        if (!$subscription || !$subscription->subscription_gateway_id) {
            return response()->json(['success' => false, 'message' => 'Subscription not found']);
        }

        $paypalId = $subscription->subscription_gateway_id;
        
        $currentStatus = $this->paypalGet("/v1/billing/subscriptions/{$paypalId}", $accessToken);
        $status = strtoupper($currentStatus['status'] ?? '');
        
        if ($status === 'ACTIVE') {
            $subscription->update(['status' => 'ACTIVE']);
            $donation->update(['subscription_status' => 'active']);
            return response()->json([
                'success' => false, 
                'message' => 'Subscription is already active',
                'status' => 'active'
            ]);
        }
        
        if ($status !== 'SUSPENDED') {
            return response()->json([
                'success' => false, 
                'message' => 'Only paused subscriptions can be resumed. Current status: ' . $status
            ]);
        }
        
        $data = ['reason' => 'User resumed subscription'];
        $response = $this->paypalPost("/v1/billing/subscriptions/{$paypalId}/activate", $data, $accessToken);

        if (in_array($response['status_code'], [204, 200])) {
            $subscription->update(['status' => 'ACTIVE']);
            $donation->update(['subscription_status' => 'active']);
            
            return response()->json([
                'success' => true, 
                'message' => 'Subscription resumed successfully',
                'status' => 'active'
            ]);
        }

        return response()->json([
            'success' => false, 
            'message' => $response['message'] ?? 'Failed to resume subscription',
            'error_details' => $response['details'] ?? null
        ]);
    }

    public function cancelSubscription($donationId)
    {
        $donation = Donation::findOrFail($donationId);
        $subscription = $donation->subscription;
        $accessToken = $this->getAccessToken();

        if (!$subscription || !$subscription->subscription_gateway_id) {
            return response()->json(['success' => false, 'message' => 'Subscription not found']);
        }

        $paypalId = $subscription->subscription_gateway_id;
        
        $currentStatus = $this->paypalGet("/v1/billing/subscriptions/{$paypalId}", $accessToken);
        $status = strtoupper($currentStatus['status'] ?? '');
        
        if (in_array($status, ['CANCELLED', 'EXPIRED', 'COMPLETED'])) {
            $subscription->update(['status' => $status]);
            $donation->update(['subscription_status' => strtolower($status)]);
            
            return response()->json([
                'success' => false, 
                'message' => 'Subscription is already ' . strtolower($status),
                'status' => strtolower($status)
            ]);
        }
        
        if (!in_array($status, ['ACTIVE', 'SUSPENDED'])) {
            return response()->json([
                'success' => false, 
                'message' => 'Subscription cannot be cancelled in current state: ' . $status
            ]);
        }
        
        $data = ['reason' => 'User cancelled subscription'];
        $response = $this->paypalPost("/v1/billing/subscriptions/{$paypalId}/cancel", $data, $accessToken);

        if (in_array($response['status_code'], [204, 200])) {
            $subscription->update(['status' => 'CANCELLED']);
            $donation->update(['subscription_status' => 'cancelled']);
            
            return response()->json([
                'success' => true, 
                'message' => 'Subscription cancelled successfully',
                'status' => 'cancelled'
            ]);
        }

        return response()->json([
            'success' => false, 
            'message' => $response['message'] ?? 'Failed to cancel subscription',
            'error_details' => $response['details'] ?? null
        ]);
    }

    public function subscriptionStatus($donationId)
    {
        $donation = Donation::findOrFail($donationId);
        $subscription = $donation->subscription;
        $accessToken = $this->getAccessToken();

        if (!$subscription || !$subscription->subscription_gateway_id) {
            return response()->json(['success' => false, 'message' => 'Subscription not found']);
        }

        $paypalId = $subscription->subscription_gateway_id;
        $url = $this->getBaseUrl() . "/v1/billing/subscriptions/{$paypalId}";

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Authorization: Bearer $accessToken"
            ]
        ]);
        $result = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($result, true);

        if (!empty($response['status'])) {
            $paypalToDb = [
                'ACTIVE' => 'active',
                'SUSPENDED' => 'paused',
                'CANCELLED' => 'cancelled',
            ];

            $dbStatus = $paypalToDb[$response['status']] ?? 'pending';

            $subscription->update(['status' => $response['status']]);
            $donation->update([
                'subscription_status' => $dbStatus,
                'next_payment_date' => $response['billing_info']['next_billing_time'] ?? null
            ]);

            return response()->json([
                'success' => true,
                'status' => $dbStatus,
                'next_payment' => $response['billing_info']['next_billing_time'] ?? null
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Failed to fetch subscription status']);
    }
}