<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use App\Notifications\PasswordChanged;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required'],   // 🔽  (special validation rule)  lowercase
            'Password' => ['required', 'confirmed', Password::defaults()],  // 🔼 DB column  uppercase
        ]);
    
        $user = $request->user();
    
        // Wrong current password
        if (!Hash::check($request->current_password, $user->Password)) {
            throw ValidationException::withMessages([
                'current_password' => __('auth.password'), // 🔽 (special validation rule)  lowercase
            ]);
        }
    
        // New password is the same as old
        if (Hash::check($request->Password, $user->Password)) {
            throw ValidationException::withMessages([
                'Password' => __('Your new password must be different from the current one.'),
            ]);
        }
    
        // Update password
        $passwordUpdated = $user->update([
            'Password' => Hash::make($request->Password),  // 🔼 DB column Upper case
        ]);
    
        if ($passwordUpdated) {
            $user->notify(new PasswordChanged($request->Password)); // ✅ No raw password
            return redirect('/profile')->with('status', 'password-updated'); // ✅ Laravel way
        }
    
        return redirect('/profile')->with('status', 'password-error');
    }
    
    
}
