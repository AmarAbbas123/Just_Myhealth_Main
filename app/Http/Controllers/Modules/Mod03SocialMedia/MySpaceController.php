<?php

namespace App\Http\Controllers\Modules\Mod03SocialMedia;

use App\Http\Controllers\Controller;

class MySpaceController extends Controller
{
    public function index()
    {
        $base = rtrim(config('social.shaunsocial.base_url'), '/');
        $path = config('social.shaunsocial.paths.my_space');
    
        return redirect()->away($base . $path);
    }
    
}
