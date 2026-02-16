<?php

namespace App\Http\Controllers\Modules\Mod00UserAccess;

use App\Http\Controllers\Controller;
use App\Notifications\ProfileUpdated;
use App\Models\User;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Notifications\EmailChangeVerification;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $userType = $user->UserType;
        $profileData = $user->ProfileData ?? [];

        return view('modules.mod-00.profile.edit', [
            'user' => $user,
            'userType' => $userType,
            'profileData' => $profileData,
            'fields' => config("user_fields.$userType", []),
            'options' => config('user_options'),
            'businessOptions' => config('business_options'),
            'medicalOptions' => config('medical_options'),
            'professionalOptions' => config('professional_options'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {

        Log::info('📥 Full request data', ['data' => $request->all()]);
        $user = $request->user();

        /* --------------------------------------------------------------------
            | 1 . Build your whitelist of fields (leave email OUT)
            * -------------------------------------------------------------------- */
       
        $profileData = $request->input('ProfileData', []);

        // Convert any single-value array fields back to string if needed:
        foreach ($profileData as $key => $val) {
            if (is_array($val)) {
                // You can decide: save as comma string or just skip
                $profileData[$key] = implode(', ', $val);
            }
        }

        /* --------------------------------------------------------------------
            | 2 . Handle a possible e‑mail change separately
            * -------------------------------------------------------------------- */
        $newEmail  = $request->input('Email');          // may be same as current
        $sameEmail = ($newEmail === $user->Email || empty($newEmail));

        if (! $sameEmail) {
            // dual‑column uniqueness check
            $request->validate([
                'Email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users', 'Email')->ignore($user->ID),
                    Rule::unique('users', 'PendingEmail')->ignore($user->ID),
                ],
            ]);

            // 👇 Define the data array
            $data = [                
                'PendingEmail' => $newEmail,
                'ProfileData'  => $profileData,
            ];

            $user->PendingEmail = $newEmail;
            $user->ProfileData = $profileData;
            $user->fill($data)->save();                 // save all changes in one go
            $user->notify(new EmailChangeVerification());

            Log::info("📧 Pending e‑mail set for user {$user->ID}: {$newEmail}");

            return back()->with(
                'status',
                'A verification link has been sent to your new address.'
            );
        }

        /* --------------------------------------------------------------------
            | 3 .  just save profile data
            * -------------------------------------------------------------------- */

        // Save only allowed fields
        $user->forceFill([            
            'ProfileData' => $profileData,
        ])->save();

        Log::info("✅ Profile updated for user {$user->ID}");
        $user->notify(new \App\Notifications\ProfileUpdated());

        return back()->with('status', 'profile-updated');
    }


    // Changing the email Address 
    public function verifyNewEmail( $id, $hash)
    {
        $user = User::findOrFail($id);

        // ✅ Automatically log the user in
        Auth::login($user);

        if (! $user->PendingEmail || ! hash_equals($hash, sha1($user->PendingEmail))) {
            abort(403, 'Invalid or expired verification link.');
        }

        // Finalize email change
        $user->Email = $user->PendingEmail;
        $user->PendingEmail = null;
        $user->EmailVerifiedAt = now(); // Optional: update verification timestamp
        $user->save();

        return redirect()->route('profile.edit')->with('status', 'Email updated successfully!');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'Password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }


    // Upload Profile Avatar/photo
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $user = $request->user();
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');

            Log::info('📸 Uploading avatar', ['user' => $user->Email ?? 'null', 'path' => $path]);

            $user->ProfilePhotoPath = $path;
            $user->save();
        }

        return back()->with('status', 'Avatar updated!');
    }

    // Upload Header Cover Photo
    public function uploadHeader(Request $request)
    {
        $request->validate([
            'header' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $user = $request->user();

        // Optional: delete old file if exists
        if ($user->HeaderPhotoPath) {
            Storage::disk('public')->delete($user->HeaderPhotoPath);
        }

        $path = $request->file('header')->store('headers', 'public');

        $user->HeaderPhotoPath = $path;
        $user->save();

        return back()->with('status', 'Header photo updated!');
    }
}
