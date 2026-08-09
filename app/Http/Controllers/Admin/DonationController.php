<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DonationDataTable;
use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DonationDataTable $dataTable)
    {
         return $dataTable->render('admin.donation.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
    try {
        $donation = Donation::findOrFail($id);

       
        $pdf = PDF::loadView('web.pdf-format.donation_invoice', compact('donation'));

       
       $mail= \Mail::send('web.emails.donation_invoice', compact('donation'), function ($message) use ($donation, $pdf) {
            $message->to($donation->email)
                    ->subject('Donation Invoice - Thank You!')
                    ->attachData($pdf->output(), 'donation_invoice.pdf');
        });

        //  if (count(\Mail::failures()) > 0) {
        //     return redirect()->back()->with('error', 'Failed to send invoice to: ' . implode(', ', \Mail::failures()));
        // }
        // dd($mail);
        $donation->update(['invoice_sent' => 1]);

        return redirect()->back()->with('success', 'Invoice has been sent successfully.');
    }catch (TransportExceptionInterface $e) {
        // SMTP / transport errors
        return redirect()->back()->with('error', 'Mail transport failed: ' . $e->getMessage());
    } catch (\Exception $e) {
        // Other errors (PDF, DB, etc.)
        return redirect()->back()->with('error', 'Failed to send invoice: ' . $e->getMessage());
    }
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

    public function subscriptionDetail($id)
{
    $donation = Donation::findOrFail($id);

    

    return view('admin.donation.subscription_detail', compact('donation'));
}
}
