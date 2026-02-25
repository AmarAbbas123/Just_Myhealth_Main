<?php

namespace App\Http\Controllers\Modules\Mod02SystemReporting;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SysUserTotalsByDay;
use App\Models\SysUserTypes;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserNumbersController extends Controller
{
    /**
     * Display User Numbers Report
     */
    public function index()
    {
        // -----------------------------
        // Fetch all relevant user types dynamically from sys_user_types
        // -----------------------------
        $userTypes = SysUserTypes::whereIn('UserTypeRef', [1, 2, 3, 10, 11, 12, 13, 30, 31, 32])
            ->pluck('UserTypeDescription', 'UserTypeRef')
            ->toArray();

        // -----------------------------
        // TOP ORANGE BOX TOTALS
        // -----------------------------
        $totalsQuery = User::select('UserType')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('UserType')
            ->pluck('total', 'UserType')
            ->toArray();
        $totalUsers = array_sum($totalsQuery);
        // Map totals to descriptions
        $totals = [
            'Total Users' => $totalUsers, // 👈 FIRST GRID
        ];
        foreach ($userTypes as $typeId => $description) {
            $totals[$description] = $totalsQuery[$typeId] ?? 0;
        }

        // -----------------------------
        // LINE CHART DATA (LAST 30 DAYS)
        // -----------------------------
        $fromDate = Carbon::now()->subDays(90)->startOfDay();

        $history = SysUserTotalsByDay::where('Date', '>=', $fromDate)
            ->orderBy('Date', 'asc')
            ->get();

        $chartData = [
            'dates' => $history->pluck('Date')->map(fn($d) => $d->format('d M'))->toArray(),
            'UserStandard'   => $history->pluck('UserStandard')->map(fn($v) => $v ?? 0),
            'UserEnhanced'   => $history->pluck('UserEnhanced')->map(fn($v) => $v ?? 0),
            'UserDischarged' => $history->pluck('UserDischargedPatient')->map(fn($v) => $v ?? 0),
            'Therapist' => $history->pluck('UserProfessionalTherapist')->map(fn($v) => $v ?? 0),
            'Trainer'   => $history->pluck('UserProfessionalPersonalTrainer')->map(fn($v) => $v ?? 0),
            'Dietitian' => $history->pluck('UserProfessionalDietitian')->map(fn($v) => $v ?? 0),
            'BusinessLocal'    => $history->pluck('UserBusinessLocal')->map(fn($v) => $v ?? 0),
            'BusinessRegional' => $history->pluck('UserBusinessRegional')->map(fn($v) => $v ?? 0),
            'BusinessNational' => $history->pluck('UserBusinessNational')->map(fn($v) => $v ?? 0),
            'BusinessGlobal' => $history->pluck('UserBusinessGlobal')->map(fn($v) => $v ?? 0),
        ];

        return view(
            'modules.mod-02.user-reports.user-numbers',
            compact('totals', 'chartData')
        );
    }
}
