<?php

namespace App\Notifications;

use App\Models\CommonCalendar;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TherapistPatientEnteredWaitingRoomNotification extends Notification
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
            ->subject('Patient Entered Session Waiting Room')
            ->greeting('Dear ' . ($notifiable->UserName ?? 'Therapist'))
            ->line($this->patientDisplayName . ' has entered the waiting room for your scheduled session.')
            ->line('Please open the session from your waiting room when you are ready.')
            ->line('Regards,')
            ->line('JustMy.Health System Automation');
    }

    public function auditMeta(): array
    {
        return [
            'ModuleRef' => 10,
            'ModuleSubRef' => 1,
            'ModuleFull' => '1001',
            'EmailSubRef' => '004',
            'Label' => 'TherapistPatientEnteredWaitingRoomNotification',
        ];
    }

    public function auditSummary(object $notifiable): string
    {
        $sessionId = $this->calendar->ID ?? 'N/A';
        $therapistName = $notifiable->UserName ?? 'Therapist';

        return "Patient waiting-room notification sent for session #{$sessionId} to {$therapistName} for patient {$this->patientDisplayName}";
    }
}
