<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists;

use App\Http\Controllers\Controller;
use App\Models\SysUserType30Attributes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ComplaintsIssuesController extends Controller
{
    // 1️⃣ 2️⃣ 3️⃣ 4️⃣
    public function complaintsIssues()
    {
        return view('modules.mod-10.01-counselling.therapists.complaints-issues');
    }
}
