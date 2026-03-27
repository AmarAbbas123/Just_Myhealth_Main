<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\SysUserMessageHistory;
use App\Models\User;
use App\Notifications\TherapistMessageReceivedNotification; 

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

        // 🔔 Send notification (from File 2)
        $this->notifyTherapistWhenPatientMessages($user, $message);

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

                    // ✅ Detailed timestamps (from File 1)
                    'time'       => $m->MessageDateTime->format('H:i'),
                    'date'       => $m->MessageDateTime->format('d M Y'),
                    'dateTime'   => $m->MessageDateTime->format('d M Y H:i'),
                    'timestamp'  => $m->MessageDateTime->toIso8601String(),
                ];
            });
    }

    protected function notifyTherapistWhenPatientMessages(User $sender, SysUserMessageHistory $message): void
    {
        // Only notify when patient sends to therapist
        if ((int) $sender->UserType !== 1 || (int) $message->ToUserType !== 30) {
            return;
        }

        $therapist = User::find($message->ToUserID);

        if (!$therapist || empty($therapist->Email)) {
            return;
        }

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
}
