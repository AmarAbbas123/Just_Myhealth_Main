<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'UserName' => ['required', 'string'],
            'Password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Find the user by username
        $user = User::where('UserName', $request->UserName)->first();

        if (! $user) {
            return back()->withErrors(['UserName' => 'We could not find a user with that username.']);
        }

        // Lookup reset token in DB by email
        $record = DB::table('password_reset_tokens')
            ->where('email', $user->Email)
            ->first();

        if (! $record || ! Hash::check($request->token, $record->token)) {
            return back()->withErrors(['UserName' => 'This password reset token is invalid or has expired.']);
        }

        // ✅ Reset the password
        $user->forceFill([
            'Password' => Hash::make($request->Password),
            'RememberToken' => Str::random(60),
        ])->save();

        // Delete used token
        DB::table('password_reset_tokens')->where('email', $user->Email)->delete();

        event(new PasswordReset($user));

        return redirect()->route('login')->with('status', 'Your password has been reset!');
    }
    
}
