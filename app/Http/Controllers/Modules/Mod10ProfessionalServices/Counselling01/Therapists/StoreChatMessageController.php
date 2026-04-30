<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists;

use App\Http\Controllers\Controller;
use App\Models\SysUserMessageHistory;
use App\Models\User;
use App\Notifications\TherapistMessageReceivedNotification;
use App\Notifications\UserMessageReceivedNotification;
use Illuminate\Http\Request;

class StoreChatMessageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'to_user_id'   => 'required|integer',
            'to_user_type' => 'required|integer',
            'message'      => 'required|string',
        ]);

        $user = auth()->user();

        $message = SysUserMessageHistory::create([
            'FromUserID'      => $user->ID,
            'FromUserType'    => (int) $user->UserType,
            'ToUserID'        => (int) $request->to_user_id,
            'ToUserType'      => (int) $request->to_user_type,
            'MessageDateTime' => now(),
            'MessageContent'  => $request->message,
        ]);

        $this->sendMessageNotification($user, $message);

        return response()->json(['success' => true]);
    }

    public function history($peerID)
    {
        $user = auth()->user();

        return SysUserMessageHistory::where(function ($q) use ($user, $peerID) {
            $q->where('FromUserID', $user->ID)
                ->where('ToUserID', $peerID);
        })
            ->orWhere(function ($q) use ($user, $peerID) {
                $q->where('FromUserID', $peerID)
                    ->where('ToUserID', $user->ID);
            })
            ->orWhere(function ($q) use ($user) {
                $q->where('FromUserID', 0)
                  ->where('ToUserID', $user->ID);
            })
            ->orderBy('MessageDateTime')
            ->get()
            ->map(function ($m) use ($user) {
                return [
                    'id'     => $m->ID,
                    'sender' => $m->FromUserID == $user->ID
                        ? ($user->UserType == 1 ? 'patient' : 'therapist')
                        : ($user->UserType == 1 ? 'therapist' : 'patient'),
                    'text'   => $m->MessageContent,
                    'time'   => $m->MessageDateTime->format('H:i'),
                ];
            });
    }

    protected function sendMessageNotification(User $sender, SysUserMessageHistory $message): void
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