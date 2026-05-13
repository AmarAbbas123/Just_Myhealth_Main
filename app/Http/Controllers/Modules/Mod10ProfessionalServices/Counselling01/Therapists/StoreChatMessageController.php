<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists;

use App\Http\Controllers\Controller;
use App\Models\SysUserMessageHistory;
use App\Services\UserMessageService;
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

        app(UserMessageService::class)->send(
            $user,
            (int) $request->to_user_id,
            (int) $request->to_user_type,
            $request->message
        );

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

}
