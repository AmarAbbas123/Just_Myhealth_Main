<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\SysMenuDisplayOption;
use Illuminate\Support\Facades\View;

class ResolveMenuFromRequest
{
    public function handle(Request $request, Closure $next)
    {
        $path = trim(strtolower($request->path()), '/');
        $menu = null;

        // 1️⃣ Dashboard special handling
        if ($path === 'dashboard') {
            $userType = optional(auth()->user())->UserType;

            if ($userType) {
                $menu = \App\Models\SysMenuDisplayOption::where('ParentID', 0)
                    ->where((string)$userType, 1)
                    ->orderBy('ID') // deterministic
                    ->first();
            }
        }

        // 2️⃣ Normal menu URL handling
        if (!$menu && $path !== '') {
            $menu = \App\Models\SysMenuDisplayOption::whereRaw(
                "TRIM(BOTH '/' FROM LOWER(MenuURL)) = ?",
                [$path]
            )->first();
        }

        view()->share('menu', $menu);

        return $next($request);
    }
}
