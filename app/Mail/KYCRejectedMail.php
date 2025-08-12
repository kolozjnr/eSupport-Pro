<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KYCRejectedMail extends Mailable
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
            subject: 'KYC Rejected'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.kyc-rejection-email',
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
