<?php

namespace App\Services;

use App\Models\SysUserMessageHistory;
use App\Models\User;
use App\Notifications\TherapistMessageReceivedNotification;
use App\Notifications\UserMessageReceivedNotification;

class UserMessageService
{
    public function send(User $sender, int $toUserId, int $toUserType, string $content): SysUserMessageHistory
    {
        $message = SysUserMessageHistory::create([
            'FromUserID'      => $sender->ID,
            'FromUserType'    => (int) $sender->UserType,
            'ToUserID'        => $toUserId,
            'ToUserType'      => $toUserType,
            'MessageDateTime' => now(),
            'MessageContent'  => $content,
        ]);

        $this->sendNotification($sender, $message);

        return $message;
    }

    protected function sendNotification(User $sender, SysUserMessageHistory $message): void
    {
        $recipient = User::find($message->ToUserID);

        if (!$recipient || empty($recipient->Email)) {
            return;
        }

        if ((int) $sender->UserType === 1 && (int) $message->ToUserType === 30) {
            $this->notifyTherapistWhenPatientMessages($sender, $recipient, $message);
            return;
        }

        if ((int) $sender->UserType === 30 && (int) $message->ToUserType === 1) {
            $this->notifyUserWhenTherapistMessages($sender, $recipient, $message);
        }
    }

    protected function notifyTherapistWhenPatientMessages(User $sender, User $therapist, SysUserMessageHistory $message): void
    {
        $sender->loadMissing('userAttributes');

        $senderFullName = trim(collect([
            $sender->userAttributes->FirstName ?? null,
            $sender->userAttributes->LastName ?? null,
        ])->filter()->implode(' '));

        if ($senderFullName === '') {
            $senderFullName = $sender->UserName ?: 'User';
        }

        $therapist->notify(new TherapistMessageReceivedNotification(
            $message,
            $sender->UserName ?: 'User',
            $senderFullName
        ));
    }

    protected function notifyUserWhenTherapistMessages(User $sender, User $user, SysUserMessageHistory $message): void
    {
        $user->notify(new UserMessageReceivedNotification(
            $message,
            $sender->UserName ?: 'Therapist'
        ));
    }
}
