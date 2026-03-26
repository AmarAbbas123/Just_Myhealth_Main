<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserTestEmail extends Notification
{
    use Queueable;

    public function __construct(
        public ?string $messageBody = null
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Test Email - JustMy.Health')
            ->greeting('Dear ' . ($notifiable->UserName ?? 'User'))
            ->line($this->messageBody ?: 'This is a temporary test email to confirm mail delivery is working.')
            ->line('Regards,')
            ->line('JustMy.Health System Automation');
    }
}