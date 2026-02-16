<?php

namespace App\Http\Controllers\Modules\Mod04MedicalData;

use App\Http\Controllers\Controller;

class HealthNewsFeedsController extends Controller
{
    public function index() {
        return view('modules.mod-04.usr-health-news-feed');
    }
}
