<?php

namespace App\Services;

use App\Models\SysUserMessageHistory;

class TherapistSessionStartNotificationToPatients
{
    public function storeSystemMessage(int $toUserID, string $message): void
    {
        $therapist = auth()->user();

        SysUserMessageHistory::create([
            'FromUserID'      => $therapist->ID,     // ✅ real user
            'FromUserType'    => $therapist->UserType,
            'ToUserID'        => $toUserID,
            'ToUserType'      => 1,                  // patient
            'MessageDateTime' => now(),
            'MessageContent'  => $message,
        ]);
    }
}
