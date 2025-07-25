<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SubscriptionExpired extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Your Subscription Has Expired')
                    ->line('Your subscription has expired and your account has been downgraded.')
                    ->action('Renew Subscription', url('/pricing'))
                    ->line('We hope to see you again soon!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Your subscription has expired and your account has been downgraded.',
            'action' => '/pricing'
        ];
    }
}