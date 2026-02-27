<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Notifications\LoginAlert;
use App\Traits\DeviceLogger;
use Illuminate\Support\Facades\DB;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        if (Auth::check()) {
            return view('modules.dashboard'); // Or wherever you want
        }

        return view('modules.mod-00.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1️⃣ Authenticate user (this sets Auth::user())
        $request->authenticate();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 2️⃣ Regenerate session *after* authentication
        $request->session()->regenerate();

        // 3️⃣ Update current session with the authenticated user_id
        DB::table('sessions')
            ->where('id', $request->session()->getId())
            ->update(['user_id' => $user->id]);

        // 4️⃣ Delete any *other* active sessions for this user
        DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('id', '!=', $request->session()->getId())
            ->delete();

        // 5️⃣ Optional: Log for debugging
        Log::info('Login redirect debug', [
            'intended'   => session('url.intended'),
            'auth_check' => Auth::check(),
            'user_id'    => Auth::id(),
        ]);

        // 6️⃣ Send login alert & log device
        $user->notify(new LoginAlert(
            $request->ip(),
            $request->header('User-Agent')
        ));

        DeviceLogger::log($user->ID, $user->UserType, 'Login');

        // 7️⃣ Redirect logic
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }



    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user) {
            // 🧹 Delete all sessions for this user (kills all browsers/devices)
            DB::table('sessions')->where('user_id', $user->id)->delete();
        }

        // 🧩 Log out after deleting user sessions
        Auth::guard('web')->logout();

        // 🧩 Get current session ID and remove it too
        $sessionId = $request->session()->getId();
        DB::table('sessions')->where('id', $sessionId)->delete();

        // 🧩 Invalidate and flush session data so Laravel won’t recreate it
        $request->session()->invalidate();
        $request->session()->flush();
        $request->session()->regenerateToken();

        // 🧠 Prevent Laravel from storing a new empty session row
        config(['session.driver' => 'array']);

        return redirect()
            ->route('login')
            ->with('status', 'You have been logged out successfully.');
    }
}
