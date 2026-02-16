<?php

namespace App\Http\Controllers\ZegoCloud;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SebastianBergmann\Environment\Console;
use Illuminate\Support\Facades\Log;

class VideoSessionController extends Controller
{
    public function generateToken(Request $request)
    {
        $appID = config('services.zegocloud.app_id');
        $serverSecret = config('services.zegocloud.server_secret');

        $roomID = $request->query('roomID');

        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        /** * UserType mapping * 30 = Therapist * 1  = Patient */
        if ($user->UserType == 30) {
            // Therapist
            $userID = 'therapist_' . $user->ID;
            $userName = $user->UserName ?? 'Therapist';
        } elseif ($user->UserType == 1) {
            // Patient
            $userID = 'patient_' . $user->ID;
            $userName = $user->UserName ?? 'Patient';
        } else {
            // Safety fallback
            $userID = 'user_' . $user->ID;
            $userName = $user->UserName ?? 'User';
        }

        Log::info('Zego token request', [
            'user_id' => $user->ID,
            'role'    => $user->UserType,
            'room'    => $roomID,
        ]);

        // Normally, Zego provides an SDK or JWT generator on server side.
        // But for test/demo, we’ll return data to frontend for JS token generation.
        return response()->json([
            'appID' => $appID,
            'serverSecret' => $serverSecret,
            'roomID' => $roomID,
            'userID' => $userID,
            'userName' => $userName,
        ]);
    }
}
