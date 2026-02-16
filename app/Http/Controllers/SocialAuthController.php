<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Carbon;

class SocialAuthController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();

    }

    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            $email = $socialUser->getEmail();

            // Fallback if provider doesn't return email (Twitter)
            $isFakeEmail = false;
            if (!$email) {
                $email = strtolower($socialUser->getNickname() ?? Str::random(8)) . "@{$provider}.local";
                $isFakeEmail = true;
            }

            $user = User::firstOrCreate(
                ['Email' => $email],
                [
                    'UserName' => $socialUser->getNickname() ?? Str::slug($socialUser->getName(), '_'),                    
                    'UserType' => 'user',
                    'Password' => bcrypt(Str::random(16)),
                ]
            );

            // ✅ If the email is fake, we mark it as verified to skip the verification step
            if ($isFakeEmail && is_null($user->EmailVerifiedAt)) {
                $user->EmailVerifiedAt = Carbon::now();
                $user->save();
            }

            Auth::login($user);

            // 🔔 Only trigger verification email if the email is real and not yet verified
            if (!$isFakeEmail && is_null($user->EmailVerifiedAt)) {
                event(new Registered($user));
                return redirect()->route('verification.notice');
            }

            // ✅ Otherwise go to dashboard (or your intended route)
            return redirect()->intended('/dashboard');

        } catch (\Exception $e) {
            Log::error("{$provider} Login Exception: " . $e->getMessage());
            return redirect()->route('login')->withErrors([
                'social' => "Failed to login with " . ucfirst($provider)
            ]);
        }
    }
}
