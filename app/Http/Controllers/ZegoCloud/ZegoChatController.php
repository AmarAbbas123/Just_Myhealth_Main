<?php

namespace App\Http\Controllers\ZegoCloud;

use App\Http\Controllers\Controller;
use App\Zego\Token04\ZEGO\ZegoServerAssistant;
use Illuminate\Http\Request;

class ZegoChatController extends Controller
{
    public function token(Request $request)
    {
        $user = auth()->user();

        $assistantToken = ZegoServerAssistant::generateToken04(
            (int) config('services.zegochat.app_id'),
            (string) $user->ID,
            config('services.zegochat.server_secret'),
            3600,
            '{}'
        );

        return response()->json([
            'token' => $assistantToken->token,
            'userID' => (string) $user->ID,
            'userName' => $user->UserName,
            'appID' => (int) config('services.zegochat.app_id'),
        ]);
    }
}
