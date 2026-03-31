<?php

namespace App\Notifications;

use App\Models\SysUserMessageHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserMessageReceivedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public SysUserMessageHistory $message,
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
            ->subject('New In-System Message Received')
            ->greeting('Dear ' . ($notifiable->UserName ?? 'User'))
            ->line('You have received an in-system message from ' . $this->therapistUserName . '.')
            ->line('Please login to view the message.')
            ->line('Regards,')
            ->line('JustMy.Health System Automation');
    }

    public function auditSummary(object $notifiable): string
    {
        $userName = $notifiable->UserName ?? 'User';
        $messageId = $this->message->ID ?? 'N/A';

        return "User message notification sent for message #{$messageId} to {$userName} from {$this->therapistUserName}";
    }
}