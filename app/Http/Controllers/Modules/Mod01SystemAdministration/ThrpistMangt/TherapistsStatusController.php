<?php

namespace App\Http\Controllers\Modules\Mod01SystemAdministration\ThrpistMangt;

use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\Request;

class TherapistsStatusController extends Controller
{
    public function index(Request $request)
    {
        $sortBy  = $request->get('sort_by', 'ID');
        $sortDir = $request->get('sort_dir', 'asc');

        $allowed = [            
            'UserName',
            'Email',
            'AccountStatus',
            'AccountSetupComplete',
            'UserCreatedDateTime',
            'UserActivatedDateTime',
        ];

        if (!in_array($sortBy, $allowed)) $sortBy = 'ID';
        if (!in_array($sortDir, ['asc', 'desc'])) $sortDir = 'asc';

        $items = User::where('UserType', 30)
            ->with(['userAttributes', 'type30'])
            ->orderBy($sortBy, $sortDir)
            ->paginate(25)
            ->appends($request->query());

        return view('modules.mod-01.thm.therapists-status', compact(
            'items',
            'sortBy',
            'sortDir'
        ));
    }
}
