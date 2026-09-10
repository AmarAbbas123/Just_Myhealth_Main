<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\AccountActivatedNotification;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Traits\DeviceLogger;


class VerifyEmailController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        if (!URL::hasValidSignature($request)) {
            abort(403, 'Invalid or expired verification link.');
        }

        $id = (int) $request->route('id');
        $user = User::find($id);

        if (!$user) {
            Log::error('❌ User not found for ID: ' . $id);
            abort(404, 'User not found.');
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            $user->NeedsEmailPrompt = false;
            // Standard accounts are real accounts. All other account types retain
            // the existing verification behaviour, including UserType 30 at 1.
            $user->SystemUser = in_array((int) $user->UserType, [1, 2], true) ? 0 : 1;
            //$user->AccountStatus=1;  // May be we just add this for Testing 
            $user->UserActivatedDateTime = now();            
            $user->save();

            event(new Verified($user));

            // 🔹 Log Device (Activation)
            DeviceLogger::log($user->ID, $user->UserType, 'Activation');

            // 🔹 Send Notification → LogSentEmail will handle sys_sent_auto_emails
            $user->notify(new AccountActivatedNotification());
        }

        Log::info('User verified', [
            'id' => $user->ID,
            'email_verified_at' => $user->EmailVerifiedAt ?? $user->EmailVerifiedAt,
        ]);

        Auth::logout();

        return redirect()->route('login')->with('verified', true);
    }
}
