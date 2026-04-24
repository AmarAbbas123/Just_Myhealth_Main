<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TherapistAccountApprovedNotification extends Notification
{
    use Queueable;

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Therapist Account Approved')
            ->greeting('Dear "' . ($notifiable->UserName ?? 'Therapist') . '"')
            ->line('Thank you for registering your Therapist account with JustMy.Health')
            ->line('Verification and validation has been completed and your account has been activated on the platform.')
            ->line('Regards,')
            ->line('JustMy.Health System Automation');
    }

    public function auditSummary(object $notifiable): string
    {
        $displayName = $notifiable->UserName ?? 'Therapist';
        $email = $notifiable->Email ?? 'unknown email';

        return "Therapist approval notification sent to {$displayName} ({$email}).";
    }

    public function auditMeta(): array
    {
        return [
            'ModuleRef'    => 1,
            'ModuleSubRef' => 0,
            'ModuleFull'   => '0100',
            'EmailSubRef'  => '002',
        ];
    }
}