<?php

namespace App\Http\Controllers\Modules\Mod03SocialMedia;

use App\Http\Controllers\Controller;

class MySpaceController extends Controller
{
    public function index() {
        return view('modules.mod-03.usr-my-space');
    }
}
