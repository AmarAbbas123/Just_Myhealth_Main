<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginAlert extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $ip, public $agent) 
    {
        //
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
            ->from('login@jmhdev.xyz', 'JustMy.Health')
            ->subject('Login Alert')
            ->greeting('Hello ' . $notifiable->UserName . '!')
            ->line('A login to your JustMy.Health account was just detected.')
            ->line('You have successfully logged in to your account.')
            ->line('If this wasn’t you, please reset your password immediately.')
            ->line("IP Address: {$this->ip}")
            ->line("Browser: {$this->agent}");

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
