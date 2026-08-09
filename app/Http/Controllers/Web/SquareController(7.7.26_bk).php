<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Models\Donation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SquareController extends Controller
{

    public function processPaymentWithSDK(Request $request)
    {
        try {
            // Try to load Square SDK classes
            if (!class_exists('\Square\SquareClient')) {
                throw new \Exception('Square SDK not properly installed');
            }

            $client = new \Square\SquareClient(
                config('services.square.token'),
                null,
                ['environment' => config('services.square.environment', 'production')]
            );

            // Check what methods are available and use the correct one
            $availableMethods = get_class_methods($client);
            $paymentsApi = null;

            foreach (['getPaymentsApi', 'paymentsApi', 'payments', 'getPayments'] as $method) {
                if (method_exists($client, $method)) {
                    $paymentsApi = $client->$method();
                    break;
                }
            }

            if (!$paymentsApi) {
                throw new \Exception('No payments API method found. Available methods: ' . implode(', ', $availableMethods));
            }

            $paymentData = [
                'source_id' => $request->nonce,
                'idempotency_key' => (string) Str::uuid(),
                'amount_money' => [
                    'amount' => ((int)$request->amount) * 100,
                    'currency' => 'USD',
                ]
            ];

            if (config('services.square.location_id')) {
                $paymentData['location_id'] = config('services.square.location_id');
            }

            $result = $paymentsApi->createPayment($paymentData);

            if ($result->isSuccess()) {
                $payment = $result->getResult()->getPayment();

                return response()->json([
                    'success' => true,
                    'payment_id' => $payment->getId(),
                    'status' => $payment->getStatus(),
                ]);
            } else {
                $errors = $result->getErrors();
                $errorMessage = !empty($errors) ? $errors[0]->getDetail() : 'Payment failed';

                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'SDK Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function success(Donation $donation)
    {
        return view('web.success', ['donation' => $donation]);
    }

    public function cancel(Donation $donation)
    {
        $donation->update(['status' => 'cancelled']);
        return view('web.cancel', ['details' => $donation]);
    }

    // Test method to check Square API connectivity
    public function testSquareConnection()
    {
        try {
            $accessToken = config('services.square.token');
            $environment = config('services.square.environment', 'sandbox');

            $baseUrl = $environment === 'production'
                ? 'https://connect.squareup.com'
                : 'https://connect.squareupsandbox.com';

            // Test with locations endpoint (simpler than payments)
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Accept' => 'application/json',
                'Square-Version' => '2023-10-18',
            ])->get($baseUrl . '/v2/locations');

            if ($response->successful()) {
                $data = $response->json();

                return response()->json([
                    'success' => true,
                    'message' => 'Square API connection successful',
                    'environment' => $environment,
                    'locations_count' => count($data['locations'] ?? []),
                    'first_location' => $data['locations'][0]['id'] ?? null
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Square API connection failed',
                    'status' => $response->status(),
                    'response' => $response->json()
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Connection test failed: ' . $e->getMessage()
            ], 500);
        }
    }


    public function processPayment(Request $request)
    {
        try {
            $accessToken = config('services.square.token');
            $environment = config('services.square.environment', 'sandbox');
            $baseUrl = $environment === 'production'
                ? 'https://connect.squareup.com'
                : 'https://connect.squareupsandbox.com';
            if (Auth::check()) {
                // Logged in user
                $userId = Auth::id();
            } else {
                // Check if user with email exists
                $user = User::where('email', $request->email)->first();

                if ($user) {
                    $userId = $user->id;
                } else {
                    // Create new user with auto password
                    $password = Str::random(10);

                    $user = User::create([
                        'name'     => $request->name,
                        'email'    => $request->email,
                        'role_id' =>   Role::USER,
                        'mobile'   => $request->phone,
                        'password' => Hash::make($password),
                        'status'   => 1,
                        'is_verified' => true,
                    ]);

                    $userId = $user->id;

                    // Send email with credentials
                    Mail::send('emails.user_welcome', [
                        'name'     => $request->name,
                        'email'    => $request->email,
                        'password' => $password,
                        'amount' => '$'.$request->amount,
                    ], function ($message) use ($request) {
                        $message->to($request->email)
                            ->subject('Welcome! Your account has been created');
                    });
                }
            }




            $donation = Donation::create([
                'user_id'       => $userId,
                'amount' => $request->amount,
                'payment_status' => 'pending',
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'payment_method' => 'Square',
                'donation_type' => $request->type,
            ]);


            if ($request->type === 'Donation_Monthly') {
                return $this->processMonthlySubscription($request, $donation, $accessToken, $baseUrl);
            } else {
                return $this->processOneTimePayment($request, $donation, $accessToken, $baseUrl);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Exception: ' . $e->getMessage(),
                'redirect_url' => route('square.cancel', $donation->id ?? 0)
            ]);
        }
    }

    private function processOneTimePayment($request, $donation, $accessToken, $baseUrl)
    {
        $paymentData = [
            'source_id' => $request->nonce,
            'idempotency_key' => (string) Str::uuid(),
            'amount_money' => [
                'amount' => ((int) $request->amount) * 100,
                'currency' => 'USD',
            ],
            'location_id' => config('services.square.location_id'),
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Square-Version' => '2023-10-18',
        ])->post($baseUrl . '/v2/payments', $paymentData);

        if ($response->successful()) {
            $payment = $response->json()['payment'];

            $donation->update([
                'payment_status' => 'success',
                'transaction_id' => $payment['id'],
                'payment_response' => json_encode($payment),
            ]);

            return response()->json([
                'success' => true,
                'redirect_url' => route('square.success', $donation->id),
            ]);
        } else {
            $errorData = $response->json();
            $donation->update([
                'payment_status' => 'failed',
                'payment_response' => json_encode($errorData),
            ]);

            return response()->json([
                'success' => false,
                'redirect_url' => route('square.cancel', $donation->id),
                'message' => $errorData['errors'][0]['detail'] ?? 'Payment failed.',
            ]);
        }
    }

    private function processMonthlySubscription($request, $donation, $accessToken, $baseUrl)
    {
        try {
            // Step 1: Create customer
            $customerData = [
                'given_name'      => $request->name,
                'email_address'   => $request->email,
                'idempotency_key' => (string) Str::uuid(),
            ];

            if (!empty($request->phone)) {
                $customerData['phone_number'] = $request->phone;
            }

            $customerResponse = Http::withHeaders([
                'Authorization'   => 'Bearer ' . $accessToken,
                'Content-Type'    => 'application/json',
                'Accept'          => 'application/json',
                'Square-Version'  => '2023-10-18',
            ])->post($baseUrl . '/v2/customers', $customerData);

            if (!$customerResponse->successful()) {
                $errorData = $customerResponse->json();
                $errorMessage = $this->parseSquareError($errorData);

                $donation->update([
                    'payment_status'   => 'failed',
                    'payment_response' => json_encode($errorData),
                ]);

                return response()->json([
                    'success'      => false,
                    'redirect_url' => route('square.cancel', $donation->id),
                    'message'      => 'Failed to create customer: ' . $errorMessage,
                ]);
            }

            $customerId = $customerResponse->json()['customer']['id'];

            // Step 2: Create card on file
            $cardData = [
                'card_nonce'      => $request->nonce,
                'cardholder_name' => $request->name,
            ];

            $cardResponse = Http::withHeaders([
                'Authorization'   => 'Bearer ' . $accessToken,
                'Content-Type'    => 'application/json',
                'Accept'          => 'application/json',
                'Square-Version'  => '2023-10-18',
            ])->post($baseUrl . "/v2/customers/{$customerId}/cards", $cardData);

            if (!$cardResponse->successful()) {
                $errorData = $cardResponse->json();
                $errorMessage = $this->parseSquareError($errorData);

                $donation->update([
                    'payment_status'   => 'failed',
                    'payment_response' => json_encode($errorData),
                ]);

                return response()->json([
                    'success'      => false,
                    'redirect_url' => route('square.cancel', $donation->id),
                    'message'      => 'Failed to save card: ' . $errorMessage,
                ]);
            }

            $cardId = $cardResponse->json()['card']['id'];

            // Step 3: Create subscription plan with correct pricing structure
            $planData = [
                'idempotency_key' => (string) Str::uuid(),
                'object'          => [
                    'type' => 'SUBSCRIPTION_PLAN',
                    'id'   => '#monthly-donation-plan-' . $request->amount . '-' . time(),
                    'subscription_plan_data' => [
                        'name'   => 'Monthly Donation - $' . $request->amount,
                        'phases' => [[
                            'cadence' => 'MONTHLY',
                            'ordinal' => 0,
                            'periods' => null,
                            'pricing' => [
                                'type' => 'STATIC',
                                'price' => [
                                    'amount'   => ((int) $request->amount) * 100,
                                    'currency' => 'USD',
                                ]
                            ]
                        ]],
                        'subscription_plan_variations' => [[
                            'type' => 'SUBSCRIPTION_PLAN_VARIATION',
                            'id'   => '#monthly-variation-' . $request->amount . '-' . time(),
                            'subscription_plan_variation_data' => [
                                'name'   => 'Monthly Donation Variation - $' . $request->amount,
                                'phases' => [[
                                    'cadence' => 'MONTHLY',
                                    'ordinal' => 0,
                                    'periods' => null,
                                    'pricing' => [
                                        'type' => 'STATIC',
                                        'price' => [
                                            'amount'   => ((int) $request->amount) * 100,
                                            'currency' => 'USD',
                                        ]
                                    ]
                                ]],
                            ],
                        ]],
                    ],
                ],
            ];

            $planResponse = Http::withHeaders([
                'Authorization'   => 'Bearer ' . $accessToken,
                'Content-Type'    => 'application/json',
                'Accept'          => 'application/json',
                'Square-Version'  => '2023-10-18',
            ])->post($baseUrl . '/v2/catalog/object', $planData);

            if (!$planResponse->successful()) {
                $errorData = $planResponse->json();
                $errorMessage = $this->parseSquareError($errorData);

                $donation->update([
                    'payment_status'   => 'failed',
                    'payment_response' => json_encode($errorData),
                ]);

                return response()->json([
                    'success'      => false,
                    'redirect_url' => route('square.cancel', $donation->id),
                    'message'      => 'Failed to create subscription plan: ' . $errorMessage,
                ]);
            }

            $catalogObject   = $planResponse->json()['catalog_object'];
            $planVariationId = $catalogObject['subscription_plan_data']['subscription_plan_variations'][0]['id'];

            // Step 4: Create subscription
            $subscriptionData = [
                'idempotency_key'   => (string) Str::uuid(),
                'location_id'       => config('services.square.location_id'),
                'plan_variation_id' => $planVariationId,
                'customer_id'       => $customerId,
                'card_id'           => $cardId,
                'start_date'        => now()->format('Y-m-d'),
                'timezone'          => 'America/New_York',
            ];

            $subscriptionResponse = Http::withHeaders([
                'Authorization'   => 'Bearer ' . $accessToken,
                'Content-Type'    => 'application/json',
                'Accept'          => 'application/json',
                'Square-Version'  => '2023-10-18',
            ])->post($baseUrl . '/v2/subscriptions', $subscriptionData);

            if ($subscriptionResponse->successful()) {
                $subscription = $subscriptionResponse->json()['subscription'];

                $donation->update([
                    'payment_status'   => 'success',
                    'transaction_id'   => $subscription['id'],
                    'customer_id'      => $customerId,
                    'subscription_id'  => $subscription['id'],
                    'card_id'              => $cardId,
                    'subscription_status'  => strtolower($subscription['status'] ?? 'active'),
                    'next_payment_date'    => $subscription['charged_through_date'] ?? now()->addMonth()->format('Y-m-d'),
                    'payment_response' => json_encode($subscription),
                ]);

                return response()->json([
                    'success'      => true,
                    'redirect_url' => route('square.success', $donation->id),
                ]);
            }

            // Subscription failed
            $errorData = $subscriptionResponse->json();
            $errorMessage = $this->parseSquareError($errorData);

            $donation->update([
                'payment_status'   => 'failed',
                'payment_response' => json_encode($errorData),
            ]);

            return response()->json([
                'success'      => false,
                'redirect_url' => route('square.cancel', $donation->id),
                'message'      => 'Failed to create subscription: ' . $errorMessage,
            ]);
        } catch (\Exception $e) {
            $donation->update([
                'payment_status'   => 'failed',
                'payment_response' => json_encode(['exception' => $e->getMessage()]),
            ]);

            return response()->json([
                'success'      => false,
                'redirect_url' => route('square.cancel', $donation->id),
                'message'      => 'Unexpected error: ' . $e->getMessage(),
            ]);
        }
    }


    // Helper method to parse Square API errors
    private function parseSquareError($errorData)
    {
        if (isset($errorData['errors']) && is_array($errorData['errors'])) {
            $messages = [];
            foreach ($errorData['errors'] as $error) {
                $message = $error['detail'] ?? $error['code'] ?? 'Unknown error';
                if (isset($error['field'])) {
                    $message = "Field '{$error['field']}': " . $message;
                }
                $messages[] = $message;
            }
            return implode(', ', $messages);
        }

        return $errorData['message'] ?? 'Unknown error occurred';
    }





    // Add these methods to your controller

    /**
     * Cancel a subscription
     */
    /**
     * Cancel a subscription
     */
    public function cancelSubscription(Request $request, $donationId)
    {
        try {
            $donation = Donation::findOrFail($donationId);

            if ($donation->donation_type !== 'Donation_Monthly' || empty($donation->subscription_id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active subscription found.'
                ], 400);
            }

            $accessToken = config('services.square.token');
            $environment = config('services.square.environment', 'sandbox');
            $baseUrl = $environment === 'production'
                ? 'https://connect.squareup.com'
                : 'https://connect.squareupsandbox.com';

            $subscriptionId = trim($donation->subscription_id);

            \Log::info('Making Square Cancel API Call', [
                'subscription_id' => $subscriptionId
            ]);

            $response = Http::asJson()->withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Square-Version' => '2023-10-18',
            ])->post($baseUrl . "/v2/subscriptions/{$donation->subscription_id}/cancel", new \stdClass());

            \Log::info('Square Cancel Response', [
                'status' => $response->status(),
                'successful' => $response->successful()
            ]);

            if ($response->successful()) {
                // DON'T update the database here
                return response()->json([
                    'success' => true,
                    'message' => 'Cancel request sent. Refreshing status...',
                    'should_refresh' => true
                ]);
            } else {
                try {
                    $errorData = $response->json();
                    $errorMessage = $this->parseSquareError($errorData);
                } catch (\Exception $e) {
                    $errorMessage = 'HTTP ' . $response->status() . ': ' . substr($response->body(), 0, 100);
                }

                \Log::error('Square Cancel Error', ['response' => $errorMessage]);

                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 400);
            }
        } catch (\Exception $e) {
            \Log::error('Cancel Subscription Exception', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Exception: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Pause a subscription
     */
    public function pauseSubscription(Request $request, $donationId)
    {
        try {
            $donation = Donation::findOrFail($donationId);

            if ($donation->donation_type !== 'Donation_Monthly' || empty($donation->subscription_id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active subscription found.'
                ], 400);
            }

            $accessToken = config('services.square.token');
            $environment = config('services.square.environment', 'sandbox');
            $baseUrl = $environment === 'production'
                ? 'https://connect.squareup.com'
                : 'https://connect.squareupsandbox.com';

            $subscriptionId = trim($donation->subscription_id);
            $pauseData = [
                'pause_effective_date' => now()->addDay()->format('Y-m-d')
            ];

            \Log::info('Making Square Pause API Call', [
                'subscription_id' => $subscriptionId,
                'pause_date' => $pauseData['pause_effective_date']
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Square-Version' => '2023-10-18',
            ])->post($baseUrl . "/v2/subscriptions/{$subscriptionId}/pause", $pauseData);

            \Log::info('Square Pause Response', [
                'status' => $response->status(),
                'successful' => $response->successful()
            ]);

            if ($response->successful()) {
                // DON'T update the database here
                // Instead, tell frontend to refresh status from Square
                return response()->json([
                    'success' => true,
                    'message' => 'Pause request sent. Refreshing status...',
                    'should_refresh' => true
                ]);
            } else {
                try {
                    $errorData = $response->json();
                    $errorMessage = $this->parseSquareError($errorData);
                } catch (\Exception $e) {
                    $errorMessage = 'HTTP ' . $response->status() . ': ' . substr($response->body(), 0, 100);
                }

                \Log::error('Square Pause Error', ['response' => $errorMessage]);

                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 400);
            }
        } catch (\Exception $e) {
            \Log::error('Pause Subscription Exception', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Exception: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Resume a paused subscription
     */
    /**
     * Resume a paused subscription
     */
    public function resumeSubscription(Request $request, $donationId)
    {
        try {
            $donation = Donation::findOrFail($donationId);

            \Log::info('Resume Subscription Request', [
                'donation_id' => $donationId,
                'donation_type' => $donation->donation_type,
                'subscription_id' => $donation->subscription_id,
                'current_status' => $donation->subscription_status
            ]);


            if ($donation->donation_type !== 'Donation_Monthly' || empty($donation->subscription_id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No subscription found.'
                ], 400);
            }

            if ($donation->subscription_status !== 'paused') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only paused subscriptions can be resumed. Current status: ' . $donation->subscription_status
                ], 400);
            }

            $accessToken = config('services.square.token');
            $environment = config('services.square.environment', 'sandbox');
            $baseUrl = $environment === 'production'
                ? 'https://connect.squareup.com'
                : 'https://connect.squareupsandbox.com';

            if (empty($accessToken)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Square configuration error'
                ], 500);
            }

            $subscriptionId = trim($donation->subscription_id);


            $getResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Square-Version' => '2023-10-18',
            ])->get($baseUrl . "/v2/subscriptions/{$subscriptionId}");

            $resumeDate = now()->addDay()->format('Y-m-d'); // Default to tomorrow

            if ($getResponse->successful()) {
                $subscriptionData = $getResponse->json()['subscription'];

                // Check if there's a scheduled pause date
                if (isset($subscriptionData['pause_effective_date'])) {
                    $pauseDate = \Carbon\Carbon::parse($subscriptionData['pause_effective_date']);
                    // Set resume date to at least one day after the pause date
                    $resumeDate = $pauseDate->addDays(1)->format('Y-m-d');

                    \Log::info('Found scheduled pause date', [
                        'pause_date' => $subscriptionData['pause_effective_date'],
                        'calculated_resume_date' => $resumeDate
                    ]);
                }
            } else {
                \Log::warning('Could not fetch subscription details for resume', [
                    'subscription_id' => $subscriptionId,
                    'status' => $getResponse->status()
                ]);
            }

            $resumeData = [
                'resume_effective_date' => $resumeDate,
                'resume_change_timing' => 'IMMEDIATE'
            ];

            \Log::info('Making Square Resume API Call', [
                'subscription_id' => $subscriptionId,
                'resume_date' => $resumeDate,
                'url' => $baseUrl . "/v2/subscriptions/{$subscriptionId}/resume"
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Square-Version' => '2023-10-18',
            ])->post($baseUrl . "/v2/subscriptions/{$subscriptionId}/resume", $resumeData);

            \Log::info('Square Resume Response', [
                'status' => $response->status(),
                'successful' => $response->successful()
            ]);

            if ($response->successful()) {
                // DON'T update the database here
                // Let getSubscriptionStatus() fetch the real status from Square
                return response()->json([
                    'success' => true,
                    'message' => 'Resume request sent. Refreshing status...',
                    'should_refresh' => true,
                    'resume_date' => $resumeDate
                ]);
            } else {
                try {
                    $errorData = $response->json();
                    $errorMessage = $this->parseSquareError($errorData);
                } catch (\Exception $e) {
                    $errorMessage = 'HTTP ' . $response->status() . ': ' . substr($response->body(), 0, 100);
                }

                \Log::error('Square Resume Error', [
                    'response' => $errorMessage,
                    'status' => $response->status()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 400);
            }
        } catch (\Exception $e) {
            \Log::error('Resume Subscription Exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Exception: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get subscription status
     */
    public function getSubscriptionStatus($donationId)
    {
        try {
            $donation = Donation::findOrFail($donationId);

            if ($donation->donation_type !== 'Donation_Monthly' || empty($donation->subscription_id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No subscription found.'
                ], 400);
            }

            $accessToken = config('services.square.token');
            $environment = config('services.square.environment', 'sandbox');
            $baseUrl = $environment === 'production'
                ? 'https://connect.squareup.com'
                : 'https://connect.squareupsandbox.com';

            if (empty($accessToken)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Square configuration error'
                ], 500);
            }

            $subscriptionId = trim($donation->subscription_id);
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Square-Version' => '2023-10-18',
            ])->get($baseUrl . "/v2/subscriptions/{$subscriptionId}");

            \Log::info('Square Get Status Response', [
                'subscription_id' => $subscriptionId,
                'status_code' => $response->status(),
                'is_successful' => $response->successful()
            ]);

            if ($response->successful()) {
                $subscription = $response->json()['subscription'];

                // IMPORTANT: Sync the actual Square status to database
                $squareStatus = strtolower($subscription['status'] ?? 'unknown');

                \Log::info('Syncing subscription status', [
                    'donation_id' => $donationId,
                    'square_status' => $squareStatus,
                    'old_db_status' => $donation->subscription_status
                ]);

                // Update database to match Square's actual status
                $donation->update([
                    'subscription_status' => $squareStatus,
                    'next_payment_date' => $subscription['charged_through_date'] ?? null
                ]);

                // Refresh the donation object
                $donation = $donation->fresh();

                return response()->json([
                    'success' => true,
                    'message' => 'Status refreshed successfully.',
                    'subscription' => $subscription,
                    'donation' => $donation->toArray(),
                    'square_status' => $squareStatus
                ]);
            } else {
                try {
                    $errorData = $response->json();
                    $errorMessage = $this->parseSquareError($errorData);
                } catch (\Exception $e) {
                    $errorMessage = 'HTTP ' . $response->status() . ': ' . substr($response->body(), 0, 100);
                }

                \Log::error('Square Status Error', [
                    'response' => $errorMessage,
                    'status' => $response->status()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 400);
            }
        } catch (\Exception $e) {
            \Log::error('Get Subscription Status Exception', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Exception: ' . $e->getMessage()
            ], 500);
        }
    }
    /**
     * Cancel a scheduled pause
     */
    public function cancelScheduledPause(Request $request, $donationId)
    {
        try {
            $donation = Donation::findOrFail($donationId);

            if ($donation->donation_type !== 'Donation_Monthly' || empty($donation->subscription_id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No subscription found.'
                ], 400);
            }

            $accessToken = config('services.square.token');
            $environment = config('services.square.environment', 'sandbox');
            $baseUrl = $environment === 'production'
                ? 'https://connect.squareup.com'
                : 'https://connect.squareupsandbox.com';

            if (empty($accessToken)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Square configuration error'
                ], 500);
            }

            $subscriptionId = trim($donation->subscription_id);

            // First get the subscription to get its version
            $getResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Square-Version' => '2023-10-18',
            ])->get($baseUrl . "/v2/subscriptions/{$subscriptionId}");

            if (!$getResponse->successful()) {
                try {
                    $errorData = $getResponse->json();
                    $errorMessage = $this->parseSquareError($errorData);
                } catch (\Exception $e) {
                    $errorMessage = 'HTTP ' . $getResponse->status();
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Failed to retrieve subscription details: ' . $errorMessage
                ], 400);
            }

            $subscriptionData = $getResponse->json()['subscription'];

            // Check if there's actually a scheduled pause
            if (!isset($subscriptionData['pause_effective_date'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'No scheduled pause found.'
                ], 400);
            }

            // Update subscription to remove the pause_effective_date
            $updatePayload = [
                'subscription' => [
                    'version' => $subscriptionData['version'],
                    'pause_effective_date' => null
                ]
            ];

            \Log::info('Canceling scheduled pause', [
                'subscription_id' => $subscriptionId,
                'current_pause_date' => $subscriptionData['pause_effective_date'],
                'version' => $subscriptionData['version']
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Square-Version' => '2023-10-18',
            ])->put($baseUrl . "/v2/subscriptions/{$subscriptionId}", $updatePayload);

            \Log::info('Cancel Scheduled Pause Response', [
                'status' => $response->status(),
                'successful' => $response->successful()
            ]);

            if ($response->successful()) {
                // DON'T update database here
                return response()->json([
                    'success' => true,
                    'message' => 'Scheduled pause cancelled. Refreshing status...',
                    'should_refresh' => true
                ]);
            } else {
                try {
                    $errorData = $response->json();
                    $errorMessage = $this->parseSquareError($errorData);
                } catch (\Exception $e) {
                    $errorMessage = 'HTTP ' . $response->status() . ': ' . substr($response->body(), 0, 100);
                }

                \Log::error('Square Cancel Scheduled Pause Error', [
                    'response' => $errorMessage
                ]);

                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 400);
            }
        } catch (\Exception $e) {
            \Log::error('Cancel Scheduled Pause Exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Exception: ' . $e->getMessage()
            ], 500);
        }
    }
}
