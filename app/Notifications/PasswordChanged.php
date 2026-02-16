<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordChanged extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $newPassword;

    public function __construct($newPassword)
    {
        $this->newPassword = $newPassword;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Password Has Been Changed')
            ->greeting('Hello ' . $notifiable->UserName . ',')
            ->line('Your password has been successfully updated.')
            ->line('If you did not make this change, please contact support immediately.')
            ->salutation('Regards, JustMy.Health Team');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
