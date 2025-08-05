<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RoleChangedNotification extends Notification
{
    use Queueable;

    protected $oldRole;
    protected $newRole;

    public function __construct($oldRole, $newRole)
    {
        $this->oldRole = $oldRole;
        $this->newRole = $newRole;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Role Has Been Updated')
            ->line("Your role has been changed from **{$this->oldRole}** to **{$this->newRole}**.")
            ->action('View Dashboard', url('/dashboard'))
            ->line('If you did not expect this change, please contact the administrator.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => "Your role has been changed from {$this->oldRole} to {$this->newRole}.",
            'old_role' => $this->oldRole,
            'new_role' => $this->newRole,
            'action_url' => url('/dashboard'),
        ];
    }
}
