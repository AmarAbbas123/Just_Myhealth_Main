<?php

namespace App\Notifications;

use App\Models\SysUserMessageHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TherapistMessageReceivedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public SysUserMessageHistory $message,
        public string $senderUserName,
        public string $senderFullName
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New In-System Message Received')
            ->greeting('Dear ' . ($notifiable->UserName ?? 'Therapist'))
            ->line('You have received an in-system message from ' . $this->senderUserName . ' / ' . $this->senderFullName . '.')
            ->line('Please login to view the message.')
            ->line('Regards,')
            ->line('JustMy.Health System Automation');
    }

    public function auditSummary(object $notifiable): string
    {
        $therapistName = $notifiable->UserName ?? 'Therapist';
        $messageId = $this->message->ID ?? 'N/A';

        return "Therapist message notification sent for message #{$messageId} to {$therapistName} from {$this->senderUserName} / {$this->senderFullName}";
    }
}