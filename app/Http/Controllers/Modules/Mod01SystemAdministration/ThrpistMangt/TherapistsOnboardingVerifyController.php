<?php

namespace App\Http\Controllers\Modules\Mod01SystemAdministration\ThrpistMangt;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SysUserType30Attributes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TherapistsOnboardingVerifyController extends Controller
{
    public function index(Request $request)
    {
        $sortBy  = $request->get('sort_by', 'ID');
        $sortDir = $request->get('sort_dir', 'asc');

        $allowed = [            
            'UserName',            
            'AccountStatus',            
        ];

        if (!in_array($sortBy, $allowed)) $sortBy = 'ID';
        if (!in_array($sortDir, ['asc', 'desc'])) $sortDir = 'asc';

        $items = User::where('UserType', 30)
            ->where('AccountSetupComplete', 0)
            ->where(function ($query) {
                $query->WhereHas('type30', function ($subQuery) {
                        $subQuery->whereNull('VerifierID');
                    });
            })
            ->with(['userAttributes', 'type30'])
            ->orderBy($sortBy, $sortDir)
            ->paginate(10)
            ->appends($request->query());

        return view('modules.mod-01.thm.therapists-onboarding-verify', compact(
            'items',
            'sortBy',
            'sortDir'
        ));
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Approved,Rejected,Further Review',
        ]);

        $user = User::where('ID', $id)
            ->where('UserType', 30)
            ->firstOrFail();

        $type30 = $user->type30 ?: SysUserType30Attributes::firstOrCreate([
            'UserID' => $user->ID,
        ]);

        if (!is_null($type30->VerifierID)) {
            return back()->with('error', 'This therapist has already been verified.');
        }

        $type30->update([
            'VerifierID' => Auth::id(),
            'VerificationStatus' => $validated['status'],
            'VerificationDate' => now()->toDateString(),
        ]);

        return back()->with('success', 'Verification status updated.');
    }
}
