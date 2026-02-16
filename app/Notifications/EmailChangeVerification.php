<?php

// app/Notifications/EmailChangeVerification.php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class EmailChangeVerification extends Notification
{
    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = URL::temporarySignedRoute(
            'email.change.verify',
            now()->addMinutes(60),
            ['id' => $notifiable->ID, 'hash' => sha1($notifiable->PendingEmail)]
        );

        return (new MailMessage)
            ->subject('Confirm your new email address')
            ->line('You requested to change your email.')
            ->action('Confirm Email Change', $url)
            ->line('If you did not request this, please ignore this email.');
    }
}
