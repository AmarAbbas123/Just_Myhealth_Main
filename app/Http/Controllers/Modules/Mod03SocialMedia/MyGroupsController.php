<?php

namespace App\Http\Controllers\Modules\Mod03SocialMedia;

use App\Http\Controllers\Controller;

class MyGroupsController extends Controller
{
    public function index()
    {
        $base = rtrim(config('social.shaunsocial.base_url'), '/');
        $path = config('social.shaunsocial.paths.my_groups');
    
        return redirect()->away($base . $path);
    }
    
}
