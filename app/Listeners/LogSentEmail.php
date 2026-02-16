<?php

namespace App\Listeners;

use Illuminate\Notifications\Events\NotificationSent;
use App\Models\User;
use App\Models\SysSentAutoEmail;
use Illuminate\Support\Facades\Log;

class LogSentEmail
{
    public function handle(NotificationSent $event): void
    {
        // ✅ Ensure recipient is a User
        if (!($event->notifiable instanceof User)) {
            Log::warning('Skipped logging email, notifiable is not a User', [
                'notification' => class_basename($event->notification),
            ]);
            return;
        }

        $userId = $event->notifiable->ID;
        $userType = $event->notifiable->UserType;

        // ✅ Resolve notification name dynamically
        $notificationName = class_basename($event->notification);
        $map = config("module_map.$notificationName");

        if (!$map) {
            Log::info("Skipping unmapped notification: {$notificationName}");
            return;
        }

        // ✅ Store email log with friendly label
        SysSentAutoEmail::create([
            'UserID'            => $userId,
            'UserType'          => $userType,
            'ModuleRef'         => $map['ModuleRef'],
            'ModuleSubRef'      => $map['ModuleSubRef'],
            'ModuleFull'        => $map['ModuleFull'],
            'EmailSubRef'       => $map['EmailSubRef'],
            'EmailSentDateTime' => now(),
            'EventNotes'        => $map['Label'], // 👈 friendly label, not class name
        ]);
    }
}
