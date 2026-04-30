<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckUserSession
{
    public function handle($request, Closure $next)
    {
        // if (Auth::check()) {
        //     $sessionId = Session::getId();

        //     // Fetch current session row
        //     $session = DB::table('sessions')->where('id', $sessionId)->first();

        //     // 🧠 Adjust column name based on your DB (use 'UserID' if that's your column)
        //     $column = isset($session->UserID) ? 'UserID' : 'user_id';

        //     $exists = DB::table('sessions')
        //         ->where('id', $sessionId)
        //         ->where($column, Auth::id())
        //         ->exists();

        //     // 🧩 Extra safety: session missing or wrong user — force logout
        //     if (!$exists || !$session || empty($session->{$column})) {
        //         Auth::logout();
        //         $request->session()->invalidate();
        //         $request->session()->regenerateToken();

        //         return redirect()
        //             ->route('login')
        //             ->with('status', 'You have been logged out from another device.');
        //     }
        // }

        // ✅ Always allow the request to continue if everything is valid
        return $next($request);
    }
}
