<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserSessionPurchaseConfirmationNotification extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Session Purchase Confirmation')
            ->greeting('Dear "' . ($notifiable->UserName ?? 'User') . '"')
            ->line('Thank you for your Therapy Session Block purchase.')
            ->line('Your available session count has now been updated.')
            ->line('Regards,')
            ->line('JustMy.Health System Automation');
    }

    public function auditSummary(object $notifiable): string
    {
        $displayName = $notifiable->UserName ?? 'User';
        $email = $notifiable->Email ?? 'unknown email';

        return "User session-purchase confirmation sent to {$displayName} ({$email}).";
    }
}
