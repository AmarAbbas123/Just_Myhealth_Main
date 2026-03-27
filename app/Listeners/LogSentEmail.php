<?php

namespace App\Listeners;

use App\Models\SysSentAutoEmail;
use App\Models\User;
use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Support\Facades\Log;

class LogSentEmail
{
    public function handle(NotificationSent $event): void
    {
        if (!($event->notifiable instanceof User)) {
            Log::warning('Skipped logging email, notifiable is not a User', [
                'notification' => class_basename($event->notification),
            ]);
            return;
        }

        $userId = $event->notifiable->ID;
        $userType = $event->notifiable->UserType;

        $notificationName = class_basename($event->notification);
        $map = config("module_map.$notificationName");

        if (!$map) {
            Log::info("Skipping unmapped notification: {$notificationName}");
            return;
        }

        $eventNotes = method_exists($event->notification, 'auditSummary')
            ? $event->notification->auditSummary($event->notifiable)
            : $map['Label'];

        SysSentAutoEmail::create([
            'UserID'            => $userId,
            'UserType'          => $userType,
            'ModuleRef'         => $map['ModuleRef'],
            'ModuleSubRef'      => $map['ModuleSubRef'],
            'ModuleFull'        => $map['ModuleFull'],
            'EmailSubRef'       => $map['EmailSubRef'],
            'EmailSentDateTime' => now(),
            'EventNotes'        => $eventNotes,
        ]);
    }
}