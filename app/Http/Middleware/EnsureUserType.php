<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserType
{
    public function handle(Request $request, Closure $next, ...$types)
    {
        if (!auth()->check()) {
            abort(403, 'Unauthorized.');
        }

        $allowedTypes = collect($types)
            ->flatMap(function ($type) {
                if (is_numeric($type)) {
                    return [(int) $type];
                }

                $group = config("user_types.$type", []);
                if (!is_array($group)) {
                    return [];
                }

                return array_map('intval', array_keys($group));
            })
            ->unique()
            ->values()
            ->all();

        if (empty($allowedTypes)) {
            abort(403, 'You do not have permission to access this section.');
        }

        if (!in_array((int) auth()->user()->UserType, $allowedTypes, true)) {
            abort(403, 'You do not have permission to access this section.');
        }

        return $next($request);
    }
}
