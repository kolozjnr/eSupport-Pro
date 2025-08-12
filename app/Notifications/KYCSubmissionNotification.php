<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class KYCSubmissionNotification extends Notification
{
    use Queueable;

    protected $customer;

    public function __construct($customer)
    {
        $this->customer = $customer;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New KYC Submission')
            ->line('A new KYC submission has been made by ' . $this->customer->user->fname . ' ' . $this->customer->user->lname . '.')
            ->line('Please log in to the admin dashboard to verify the customer.')
            ->action('Review KYC', url('/admin/kyc-verification/' . $this->customer->id))
            ->line('Thank you.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'New KYC submission from ' . $this->customer->user->fname . ' ' . $this->customer->user->lname,
            'customer_id' => $this->customer->id
        ];
    }
}

