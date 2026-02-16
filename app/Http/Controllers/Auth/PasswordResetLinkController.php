<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Notifications\CustomResetPassword;


class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'LoginField' => ['required', 'string'],
        ]);

        $login = $request->input('LoginField');

        // Try to find user by username OR email
        $user = User::where('UserName', $login)
                    ->orWhere('Email', $login)
                    ->first();

        if (! $user) {
            return back()->withInput($request->only('LoginField'))
                ->withErrors(['LoginField' => __('We couldn\'t find a user with that email or username.')]);
        }

        // Create token manually
        $token = Password::createToken($user);

        // Build custom URL with username
        $url = url(route('password.reset', [
            'token' => $token,
            'username' => $user->UserName,
        ], false));

        // Send notification
        $user->notify(new CustomResetPassword($token, $url));

        return back()->with('status', __('We have emailed your password reset link!'));
    }
    
}
