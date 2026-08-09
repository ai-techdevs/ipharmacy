<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PlanDataTable;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     private function getBaseUrl()
    {
        return env('PAYPAL_MODE') === 'live'
            ? 'https://api-m.paypal.com'
            : 'https://api-m.sandbox.paypal.com';
    }

    private function getAccessToken()
    {
        $mode     = env('PAYPAL_MODE', 'sandbox');
        $clientId = env($mode === 'sandbox' ? 'PAYPAL_SANDBOX_CLIENT_ID' : 'PAYPAL_LIVE_CLIENT_ID');
        $secret   = env($mode === 'sandbox' ? 'PAYPAL_SANDBOX_CLIENT_SECRET' : 'PAYPAL_LIVE_CLIENT_SECRET');

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

    public function index(PlanDataTable $dataTable)
    {
        return $dataTable->render("admin.plan.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('admin.plan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'interval_unit' => 'required|in:MONTH,YEAR',
            'interval_count' => 'required|integer|min:1',
            'amount' => 'required|numeric|min:0.01',
            'currency' => 'required|string|size:3',
            'status' => 'required',
        ]);

        try {
            $accessToken = $this->getAccessToken();
            if (!$accessToken) {
                return back()->with('error', 'Unable to get PayPal access token.');
            }

           
            $productData = [
                'name' => $request->name,
                'description' => $request->description ?? '',
                'type' => 'SERVICE',
                'category' => 'OTHER'
            ];
// dd($accessToken);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->getBaseUrl() . "/v1/catalogs/products");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Content-Type: application/json",
                "Authorization: Bearer $accessToken"
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($productData));
            $result = curl_exec($ch);
            curl_close($ch);

            $productResponse = json_decode($result, true);
            //
            //dd($productResponse);
            $productId = $productResponse['id'] ?? env('PAYPAL_PRODUCT_ID');

            if (!$productId) {
                return back()->with('error', 'Unable to create PayPal product.');
            }

            // ---------------- Create PayPal Plan ----------------
            $planData = [
                'product_id' => $productId,
                'name' => $request->name,
                'description' => $request->description ?? '',
                'billing_cycles' => [
                    [
                        'frequency' => [
                            'interval_unit' => $request->interval_unit,
                            'interval_count' => (int)$request->interval_count
                        ],
                        'tenure_type' => 'REGULAR',
                        'sequence' => 1,
                        'total_cycles' => 0,
                        'pricing_scheme' => [
                            'fixed_price' => [
                                'value' => number_format($request->amount, 2, '.', ''),
                                'currency_code' => $request->currency
                            ]
                        ]
                    ]
                ],
                'payment_preferences' => [
                    'auto_bill_outstanding' => true,
                    'setup_fee' => ['value' => '0', 'currency_code' => $request->currency],
                    'setup_fee_failure_action' => 'CONTINUE',
                    'payment_failure_threshold' => 3
                ]
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->getBaseUrl() . "/v1/billing/plans");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Content-Type: application/json",
                "Authorization: Bearer $accessToken"
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($planData));
            $result = curl_exec($ch);
            curl_close($ch);

            $planResponse = json_decode($result, true);
            //dd( $planResponse);
            $paypalPlanId = $planResponse['id'] ?? null;

            if (!$paypalPlanId) {
                return back()->with('error', 'Unable to create PayPal plan.');
            }

            // ---------------- Save to Database ----------------
            $plan = Plan::create([
                'name' => $request->name,
                'description' => $request->description,
                'paypal_product_id' => $productId,
                'paypal_plan_id' => $paypalPlanId,
                'interval_unit' => $request->interval_unit,
                'interval_count' => $request->interval_count,
                'amount' => $request->amount,
                'currency' => $request->currency,
                'status' => $request->status ? 'ACTIVE' : 'INACTIVE'
            ]);

            return redirect()->route('admin.plan.index')->with('success', 'Plan created successfully!');
        } catch (\Throwable $e) {
            \Log::error('PayPal Plan creation error: ' . $e->getMessage());
            return redirect()->route('admin.plan.index')->with('error', 'Something went wrong while creating the plan.'.$e->getMessage());
        }
    }
  

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
