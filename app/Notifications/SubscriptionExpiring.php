<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SubscriptionExpiring extends Notification implements ShouldQueue
{
    use Queueable;

    public $remainingDays;

    public function __construct($remainingDays)
    {
        $this->remainingDays = $remainingDays;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Your Subscription Expires Soon')
                    ->line("Your subscription will expire in {$this->remainingDays} days.")
                    ->action('Renew Subscription', url('/pricing'))
                    ->line('Thank you for using our service!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Your subscription will expire in {$this->remainingDays} days.",
            'action' => '/pricing'
        ];
    }
}