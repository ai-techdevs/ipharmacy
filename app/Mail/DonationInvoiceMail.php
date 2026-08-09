<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DonationInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $patient;
    public $medicine;
    public $filePath;
    public $doctorName;

    public function __construct($patient, $medicine, $filePath, $doctorName)
    {
        $this->patient = $patient;
        $this->medicine = $medicine;
        $this->filePath = $filePath;
        $this->doctorName = $doctorName;
    }

    public function build()
    {
        return $this->subject('Patient Query for Your Review')
                    ->view('emails.medicine_query')
                    ->with([
                        'patient' => $this->patient,
                        'medicine' => $this->medicine,
                        'doctorName' => $this->doctorName,
                    ])
                    ->attach($this->filePath, [
                        'as' => 'PatientReport.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}
