<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SysUserMessageHistory;

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

        SysUserMessageHistory::create([
            'FromUserID'      => $user->ID,
            'FromUserType'    => (int) $user->UserType,
            'ToUserID'        => (int) $request->to_user_id,
            'ToUserType'      => (int) $request->to_user_type,
            'MessageDateTime' => now(),
            'MessageContent' => $request->message,
        ]);

        return response()->json(['success' => true]);
    }

    public function history(Request $request, $peerID)
    {
        $user = auth()->user();

        if ($request->boolean('debug')) {
            if (!app()->environment(['local', 'development'])) {
                abort(403);
            }

            $rawRows = DB::table('sys_user_message_history')
                ->where(function ($q) use ($user, $peerID) {
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
                ->get([
                    'ID',
                    'FromUserID',
                    'FromUserType',
                    'ToUserID',
                    'ToUserType',
                    'MessageDateTime',
                    'MessageContent',
                    'created_at',
                    'updated_at',
                ]);

            $eloquentRows = SysUserMessageHistory::query()
                ->withoutGlobalScopes()
                ->where(function ($q) use ($user, $peerID) {
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
                ->get([
                    'ID',
                    'FromUserID',
                    'FromUserType',
                    'ToUserID',
                    'ToUserType',
                    'MessageDateTime',
                    'MessageContent',
                    'created_at',
                    'updated_at',
                ]);

            $dbNow = null;
            try {
                $row = DB::selectOne('select CURRENT_TIMESTAMP as db_now');
                $dbNow = $row?->db_now ?? null;
            } catch (\Throwable $e) {
                $dbNow = null;
            }

            return response()->json([
                'server_now' => now()->toDateTimeString(),
                'app_timezone' => config('app.timezone'),
                'db_now' => $dbNow,
                'peer_id' => $peerID,
                'user_id' => $user->ID,
                'raw_count' => $rawRows->count(),
                'eloquent_count' => $eloquentRows->count(),
                'raw_rows' => $rawRows,
                'eloquent_rows' => $eloquentRows,
            ]);
        }

        return SysUserMessageHistory::query()
            ->withoutGlobalScopes()
            ->where(function ($q) use ($user, $peerID) {
                $q->where('FromUserID', $user->ID)
                    ->where('ToUserID', $peerID);
            })
            ->orWhere(function ($q) use ($user, $peerID) {
                $q->where('FromUserID', $peerID)
                    ->where('ToUserID', $user->ID);
            })
            ->orWhere(function ($q) use ($user) {
                $q->where('FromUserID', 0)
                  ->where('ToUserID', $user->ID);   // $peerID
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
                    'date'      => $m->MessageDateTime->format('d M Y'),
                    'dateTime'  => $m->MessageDateTime->format('d M Y H:i'),
                    'timestamp' => $m->MessageDateTime->toIso8601String(),
                ];
            });
    }

}
