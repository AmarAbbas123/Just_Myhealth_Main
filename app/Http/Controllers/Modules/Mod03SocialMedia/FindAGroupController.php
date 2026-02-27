<?php

namespace App\Http\Controllers\Modules\Mod03SocialMedia;

use App\Http\Controllers\Controller;

class FindAGroupController extends Controller
{
    public function index()
    {
        $base = rtrim(config('social.shaunsocial.base_url'), '/');
        $path = config('social.shaunsocial.paths.find_group');
    
        return redirect()->away($base . $path);
    }
    
}
