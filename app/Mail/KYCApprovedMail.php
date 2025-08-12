<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KYCApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;

    public function __construct($customer)
    {
        $this->customer = $customer;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'KYC Approved'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.kyc-approval-email',
            with: [
                'data' => $this->customer
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
