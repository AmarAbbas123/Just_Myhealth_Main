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
        $auditUser = $event->notifiable instanceof User
            ? $event->notifiable
            : (method_exists($event->notification, 'auditUser')
                ? $event->notification->auditUser($event->notifiable)
                : null);

        if (!($auditUser instanceof User)) {
            Log::warning('Skipped logging email, notifiable is not a User', [
                'notification' => class_basename($event->notification),
            ]);
            return;
        }

        $userId = $auditUser->ID;
        $userType = $auditUser->UserType;

        $notificationName = class_basename($event->notification);
        $map = config("module_map.$notificationName");

        if (!$map && method_exists($event->notification, 'auditMeta')) {
            $map = $event->notification->auditMeta();
            Log::info("Using notification-provided audit metadata for unmapped notification: {$notificationName}");
        }

        if (!$map) {
            Log::info("Skipping unmapped notification: {$notificationName}");
            return;
        }

        $eventNotes = method_exists($event->notification, 'auditSummary')
            ? $event->notification->auditSummary($auditUser)
            : ($map['Label'] ?? $notificationName);

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