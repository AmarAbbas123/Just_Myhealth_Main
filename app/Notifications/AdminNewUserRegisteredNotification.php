<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminNewUserRegisteredNotification extends Notification
{
    use Queueable;

    public function __construct(public User $user)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New User Registered')
            ->greeting('Dear Admin')
            ->line('A new user with UserName "' . $this->user->UserName . '" and userType "' . $this->user->UserType . '" has registered on the platform.')
            ->line('Regards,')
            ->line('JustMy.Health System Automation');
    }

    public function auditUser(object $notifiable): User
    {
        return $this->user;
    }

    public function auditSummary(object $notifiable): string
    {
        return 'Admin new-user registration notification sent for '
            . $this->user->UserName
            . ' (UserType ' . $this->user->UserType . ')';
    }
}