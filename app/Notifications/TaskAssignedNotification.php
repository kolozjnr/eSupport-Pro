<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskAssignedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
   public array $ticketIds;

    public function __construct(array $ticketIds)
    {
        $this->ticketIds = $ticketIds;
    }

    // Send to both mail and database
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    // Mail content
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Tickets Assigned to You')
            ->greeting('Hello ' . $notifiable->lname . ',')
            ->line('You have been assigned new tickets.')
            //->line('Ticket IDs: ' . implode(', ', $this->ticketIds))
            ->action('View Tickets', url('/tickets'))
            ->line('Thank you for your attention.');
    }

    // Database content
    public function toDatabase($notifiable)
    {
        return [
            'message' => 'New tickets have been assigned to you.',
            'ticket_ids' => $this->ticketIds,
            'assigned_at' => now(),
        ];
    }
}
