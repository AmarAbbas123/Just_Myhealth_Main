<?php

namespace App\Notifications;

use App\Models\CommonCalendar;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TherapistSessionReminder extends Notification
{
    use Queueable;

    public function __construct(
        public CommonCalendar $calendar,
        public string $patientDisplayName
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
            ->greeting('Dear ' . ($notifiable->UserName ?? 'Therapist'))
            ->line('You have a scheduled session with ' . $this->patientDisplayName . ' in 30 Minutes.')
            ->line('Regards,')
            ->line('JustMy.Health System Automation');
    }

    public function auditSummary(object $notifiable): string
    {
        $sessionId = $this->calendar->ID ?? 'N/A';
        $sessionStartUtc = $this->calendar->SessionDateTimeFrom
            ? $this->calendar->SessionDateTimeFrom->copy()->setTimezone('UTC')->format('Y-m-d H:i:s')
            : 'N/A';
        $therapistName = $notifiable->UserName ?? 'Therapist';

        return "Therapist 30-minute session reminder sent for session #{$sessionId} at {$sessionStartUtc} to {$therapistName} for patient {$this->patientDisplayName}";
    }
}
