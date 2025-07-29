<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TicketUploadedOnbehalfofCustomerNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $userFname;
    public $ticketId;

    public function __construct($userFname, $ticketId)
    {
        $this->userFname = $userFname;
        $this->ticketId = $ticketId;
    }

    /**
     * Delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Email content.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting('Hello ' . $notifiable->fname . ',')
            ->line("{$this->userFname} has uploaded a ticket on your behalf.")
            ->line("Please log in to your account to view and confirm the ticket.")
            ->action('View Ticket', url("/dashboard/tickets/{$this->ticketId}"))
            ->line('Thank you for using ' . config('app.name') . '!');
    }

    /**
     * Data for database notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => "{$this->userFname} uploaded a ticket for you. Please confirm it.",
            'ticket_id' => $this->ticketId,
            'url' => url("/dashboard/tickets/{$this->ticketId}")
        ];
    }
}
