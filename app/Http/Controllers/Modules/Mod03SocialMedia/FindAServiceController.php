<?php

namespace App\Http\Controllers\Modules\Mod03SocialMedia;

use App\Http\Controllers\Controller;

class FindAServiceController extends Controller
{
    public function index()
    {
        $base = rtrim(config('social.shaunsocial.base_url'), '/');
        $path = config('social.shaunsocial.paths.find_service');

        $next = $base . $path;

        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        $token = session('kc_access_token');

        if (!$token) {
            return redirect()->route('login')->withErrors([
                'msg' => 'Session expired. Please login again.'
            ]);
        }
       

        return redirect()->away(
            $base . '/sso-login?token=' . urlencode($token) . '&next=' . urlencode($next)
        );
    }
    
}
