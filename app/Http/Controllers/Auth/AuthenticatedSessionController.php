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
use App\Services\KeycloakService;
use response;

class AuthenticatedSessionController extends Controller
{

    protected KeycloakService $keycloak;

    public function __construct()
    {
        $this->keycloak = new KeycloakService();
    }


    /**
     * Display the login view.
     */
    public function create(): View
    {
        if (Auth::check()) {
            return view('modules.dashboard');
        }

        return view('modules.mod-00.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1️⃣ Breeze login
        $request->authenticate();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user) {
            abort(500, 'Auth failed after login');
        }

        // 2️⃣ Regenerate session
        $request->session()->regenerate();

        // 3️⃣ 🔥 Login to Keycloak (hidden)
        $kcResponse = $this->keycloak->loginDirectGrant(
            $request->input('UserName'),
            $request->input('Password')
        );

        if ($kcResponse && isset($kcResponse['access_token'])) {

            // ✅ Store token ONLY if success
            session([                
                'kc_access_token' => $kcResponse['access_token'],
                'kc_refresh_token' => $kcResponse['refresh_token'] ?? null,
            ]);
        
            Log::info('Keycloak login SUCCESS', ['user_id' => Auth::id()]);
        
        } else {
        
            // ❗ DO NOT logout user
            Log::warning('Keycloak login skipped (user not in KC yet)', [
                'user_id' => $user->id
            ]);
        }      

        // 5️⃣ Session DB handling
        DB::table('sessions')
            ->where('id', $request->session()->getId())
            ->update(['user_id' => $user->id]);

        DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('id', '!=', $request->session()->getId())
            ->delete();

        // 6️⃣ Logs
        Log::info('Login redirect debug', ['intended'   => session('url.intended'), 'auth_check' => Auth::check(), 'user_id'    => Auth::id(),]);
        Log::info('Login success with Keycloak', ['user_id' => $user->id,]);
        Log::error('Keycloak full response', ['response' => $kcResponse]);

        if (!$user) {
            dd('User is NULL after login');
        }

        // 7️⃣ Alerts
        $user->notify(new LoginAlert($request->ip(), $request->header('User-Agent')));

        DeviceLogger::log($user->ID, $user->UserType, 'Login');

        // 8️⃣ Email verification
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        // ✅ FINAL: go to YOUR dashboard (NOT shaunsocial)
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

        return redirect()->route('login')->with('status', 'You have been logged out successfully.');
    }
}
