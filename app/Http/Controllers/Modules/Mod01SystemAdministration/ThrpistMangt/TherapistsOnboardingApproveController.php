<?php

namespace App\Http\Controllers\Modules\Mod01SystemAdministration\ThrpistMangt;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SysUserType30Attributes;
use App\Notifications\TherapistAccountApprovedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TherapistsOnboardingApproveController extends Controller
{
    public function index(Request $request)
    {
        $sortBy  = $request->get('sort_by', 'ID');
        $sortDir = $request->get('sort_dir', 'asc');

        $allowed = [
            'UserName',
            'AccountStatus',
        ];

        if (!in_array($sortBy, $allowed)) {
            $sortBy = 'ID';
        }

        if (!in_array($sortDir, ['asc', 'desc'])) {
            $sortDir = 'asc';
        }

        $items = User::where('UserType', 30)
            ->where('AccountStatus', 0)
            ->whereHas('type30', function ($query) {
                $query->where('VerificationStatus', 'Approved');
            })
            ->with(['userAttributes', 'type30'])
            ->orderBy($sortBy, $sortDir)
            ->paginate(10)
            ->appends($request->query());

        return view('modules.mod-01.thm.therapists-onboarding-approve', compact(
            'items',
            'sortBy',
            'sortDir'
        ));
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:Approved,Rejected,Further Review',
            'approver_notes' => 'required|string|max:128',
        ]);

        $user = User::where('ID', $id)
            ->where('UserType', 30)
            ->where('AccountStatus', 0)
            ->firstOrFail();

        $type30 = $user->type30 ?: SysUserType30Attributes::firstOrCreate([
            'UserID' => $user->ID,
        ]);

        if (!is_null($type30->ApproverID)) {
            return back()->with('error', 'This therapist has already been approved.');
        }

        $type30->update([
            'ApproverID' => Auth::id(),
            'ApproverNotes' => $validated['approver_notes'],
            'ApprovalStatus' => $validated['status'],
            'ApprovalDate' => now()->toDateString(),
        ]);

        // Update SystemUser column
        $user->update([
            'SystemUser' => 0,
        ]);

        if ($validated['status'] === 'Approved') {
            $user->update([
                'AccountStatus' => 1,
                'UserActivatedDateTime' => now(),
            ]);

            // Notify therapist only when admin approves and activates account.
            $user->notify(new TherapistAccountApprovedNotification());
        }

        return back()->with('success', 'Approval status updated.');
    }
}
