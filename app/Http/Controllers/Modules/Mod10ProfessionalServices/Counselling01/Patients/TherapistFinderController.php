<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Patients;

use App\Http\Controllers\Controller;
use App\Models\User;

class TherapistFinderController extends Controller
{
    public function index()
    {
        // Get all therapists with UserType = 30 and SystemUser = 0
        $therapists = User::where('UserType', 30)
            ->where('SystemUser', 0)
            ->where('AccountStatus', 1)
            ->with(['userAttributes', 'type30'])
            ->get();
        return view('modules.mod-10.01-counselling.patients.therapists-finder', compact('therapists'));
    }
}
