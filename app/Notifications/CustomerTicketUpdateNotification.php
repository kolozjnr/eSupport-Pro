<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerTicketUpdateNotification extends Notification
{
    use Queueable;
    public $status;
    public $ticketId;

    /**
     * Create a new notification instance.
     */
    public function __construct($status, $ticketId)
    {
        $this->status = $status;
        $this->ticketId = $ticketId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('Tickets Status Update')
        ->greeting('Hello ' . $notifiable->lname . ',')
        ->line('Your status has been updated to **' . $this->status . '**,')
        ->action('View Tickets', url('dashboard/tickets/view-single-ticket/' . $this->ticketId))
        ->line('Thank you for your attention.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Ticket Status Updated',
            'message' => 'Your ticket status has been updated to ' . $this->status,
            'status' => $this->status,
            'ticket_id' => $this->ticketId,
            'url' => url('dashboard/tickets/view-single-ticket/' . $this->ticketId),
        ];
    }
}
