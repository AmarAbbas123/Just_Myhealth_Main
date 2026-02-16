<?php

namespace App\Http\Controllers\Modules\Mod05BusinessDirectory;

use App\Http\Controllers\Controller;

class FindABusinessController extends Controller
{
    public function index() {
        return view('modules.mod-05.usr-business-finder');
    }
}
