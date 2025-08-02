<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomerNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectLine;
    public $messageBody;
    public $customer;
    
    /**
     * Create a new message instance.
     */
    public function __construct($subjectLine, $messageBody, $customer)
    {
        $this->subjectLine = $subjectLine;
        $this->messageBody = $messageBody;
        $this->customer = $customer;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectLine,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Get settings (adjust this based on your settings model/config)
        $settings = \App\Models\Setting::first(); // or however you get settings
        
        return new Content(
            view: 'emails.customer-notification',
            with: [
                'subjectLine' => $this->subjectLine,
                'messageBody' => $this->messageBody,
                'user' => $this->customer->user, // This matches the template variable
                'settings' => $settings // Add settings for the template
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}