<?php

namespace App\Notifications;

use App\Models\CommonCalendar;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserSessionReminder extends Notification
{
    use Queueable;

    public function __construct(
        public CommonCalendar $calendar,
        public string $therapistUserName
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Session Reminder - Starts In 30 Minutes')
            ->greeting('Dear ' . ($notifiable->UserName ?? 'User'))
            ->line('You have a scheduled session with ' . $this->therapistUserName . ' in 30 Minutes.')
            ->line('Regards,')
            ->line('JustMy.Health System Automation');
    }

    public function auditSummary(object $notifiable): string
    {
        $sessionId = $this->calendar->ID ?? 'N/A';
        $userName = $notifiable->UserName ?? 'User';

        return "User 30-minute session reminder sent for session #{$sessionId} to {$userName} with therapist {$this->therapistUserName}";
    }
}