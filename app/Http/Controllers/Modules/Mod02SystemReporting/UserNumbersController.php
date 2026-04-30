<?php

namespace App\Http\Controllers\Modules\Mod02SystemReporting;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SysUserTotalsByDay;
use App\Models\SysUserTypes;
use Carbon\Carbon;

class UserNumbersController extends Controller
{
    /**
     * Display User Numbers Report
     */
    public function index()
    {
        // -------------------------------------------------
        // Fetch all relevant user types dynamically
        // -------------------------------------------------
        $userTypes = SysUserTypes::whereIn('UserTypeRef', [1,2,3,10,11,12,13,30,31,32])
            ->pluck('UserTypeDescription', 'UserTypeRef')
            ->toArray();

        // -------------------------------------------------
        // TOP ORANGE BOX TOTALS
        // -------------------------------------------------
        $totalsQuery = User::select('UserType')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('UserType')
            ->pluck('total', 'UserType')
            ->toArray();

        $totalUsers = array_sum($totalsQuery);

        $totals = [
            'Total Users' => $totalUsers,
        ];

        foreach ($userTypes as $typeId => $description) {
            $totals[$description] = $totalsQuery[$typeId] ?? 0;
        }

        // -------------------------------------------------
        // LAST 90 DAYS CONTINUOUS DATA (IMPORTANT FIX)
        // -------------------------------------------------
        $startDate = Carbon::today()->subDays(89); // include today = 90 days
        $endDate   = Carbon::today();

        // Fetch database rows and key them by date
        $history = SysUserTotalsByDay::whereBetween('Date', [$startDate, $endDate])
            ->get()
            ->keyBy(function ($item) {
                return Carbon::parse($item->Date)->format('Y-m-d');
            });

        // Prepare arrays
        $dates = [];
        $userStandard = [];
        $userEnhanced = [];
        $userDischarged = [];
        $therapist = [];
        $trainer = [];
        $dietitian = [];
        $businessLocal = [];
        $businessRegional = [];
        $businessNational = [];
        $businessGlobal = [];

        // Loop through every day (fills missing days with 0)
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {

            $formatted = $date->format('Y-m-d');
            $row = $history[$formatted] ?? null;

            $dates[] = $date->format('d M');

            $userStandard[]   = $row->UserStandard ?? 0;
            $userEnhanced[]   = $row->UserEnhanced ?? 0;
            $userDischarged[] = $row->UserDischargedPatient ?? 0;
            $therapist[]      = $row->UserProfessionalTherapist ?? 0;
            $trainer[]        = $row->UserProfessionalPersonalTrainer ?? 0;
            $dietitian[]      = $row->UserProfessionalDietitian ?? 0;
            $businessLocal[]  = $row->UserBusinessLocal ?? 0;
            $businessRegional[] = $row->UserBusinessRegional ?? 0;
            $businessNational[] = $row->UserBusinessNational ?? 0;
            $businessGlobal[] = $row->UserBusinessGlobal ?? 0;
        }

        // Chart data
        $chartData = [
            'dates' => $dates,
            'UserStandard'   => $userStandard,
            'UserEnhanced'   => $userEnhanced,
            'UserDischarged' => $userDischarged,
            'Therapist'      => $therapist,
            'Trainer'        => $trainer,
            'Dietitian'      => $dietitian,
            'BusinessLocal'  => $businessLocal,
            'BusinessRegional'=> $businessRegional,
            'BusinessNational'=> $businessNational,
            'BusinessGlobal' => $businessGlobal,
        ];

        return view(
            'modules.mod-02.user-reports.user-numbers',
            compact('totals', 'chartData')
        );
    }
}