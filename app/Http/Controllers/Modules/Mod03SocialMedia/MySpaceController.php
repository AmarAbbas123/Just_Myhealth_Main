<?php

namespace App\Http\Controllers\Modules\Mod03SocialMedia;

use App\Http\Controllers\Controller;

class MySpaceController extends Controller
{
    public function index()
    {
        return redirect()->away(
            'https://jmhmod03.xyz/openid/auth/keycloak'
        );
        // $base = rtrim(config('social.shaunsocial.base_url'), '/');
        // $path = config('social.shaunsocial.paths.my_space');

        // return redirect()->away($base . $path);
    }
}
