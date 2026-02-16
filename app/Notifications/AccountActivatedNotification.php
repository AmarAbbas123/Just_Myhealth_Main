<?php

// app/Notifications/AccountActivatedNotification.php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AccountActivatedNotification extends Notification
{
    use Queueable;

    public function via($notifiable): array
    {
        return ['mail']; // 👈 triggers NotificationSent

    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Account Activated')
            ->greeting('Hello ' . $notifiable->UserName . '!')
            ->line('Your account has been activated successfully.');
    }
}
