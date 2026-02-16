<?php

namespace App\Http\Controllers\Modules\Mod02SystemReporting;

use App\Http\Controllers\Controller;
use App\Models\SysFinanceUserType30Fees;
use App\Models\SysFinanceUserType30ServiceCredits;
use Illuminate\Support\Facades\Auth;

class FinanceReportsRevenueController extends Controller
{
    /**
     * Display Revenue Report
     */
    public function revenue()
    {
        // Get current year
        $currentYear = date('Y');
        $currentYearStart = "$currentYear-01-01";
        $currentYearEnd = "$currentYear-12-31";

        // ==========================================
        // ALL TIME REVENUE
        // ==========================================

        // Total Fees (All Time)
        $totalFees = SysFinanceUserType30Fees::sum('CreditValue');

        // Total Service Credits (All Time)
        $totalCredits = SysFinanceUserType30ServiceCredits::sum('CreditValue');

        // Total Revenue (All Time)
        $allTimeTotal = $totalFees + $totalCredits;

        // ==========================================
        // THIS YEAR REVENUE
        // ==========================================

        // This Year Fees
        $thisYearFees = SysFinanceUserType30Fees::whereBetween('CreditDate', [$currentYearStart, $currentYearEnd])
            ->sum('CreditValue');

        // This Year Service Credits
        $thisYearCredits = SysFinanceUserType30ServiceCredits::whereBetween('CreditDate', [$currentYearStart, $currentYearEnd])
            ->sum('CreditValue');

        // This Year Total Revenue
        $thisYearTotal = $thisYearFees + $thisYearCredits;

        // ==========================================
        // Prepare Data for View
        // ==========================================

        $allTimeRevenue = [
            'total' => number_format($allTimeTotal, 2),
            'registration_fees' => number_format($totalFees, 2),
            'session_fees' => number_format($totalCredits, 2),
        ];

        $thisYearRevenue = [
            'total' => number_format($thisYearTotal, 2),
            'registration_fees' => number_format($thisYearFees, 2),
            'session_fees' => number_format($thisYearCredits, 2),
        ];

        // ==========================================
        // Raw Values for Data Source Display
        // ==========================================
        $dataSource = [
            'all_time' => [
                'fees_table' => $totalFees,
                'credits_table' => $totalCredits,
                'total_calculation' => "$totalFees + $totalCredits = $allTimeTotal"
            ],
            'this_year' => [
                'fees_table' => $thisYearFees,
                'credits_table' => $thisYearCredits,
                'total_calculation' => "$thisYearFees + $thisYearCredits = $thisYearTotal"
            ]
        ];

        // ==========================================
        // Fetch All Records from Both Tables
        // ==========================================
        $feesRecords = SysFinanceUserType30Fees::orderBy('CreditDate', 'desc')->get();
        $creditsRecords = SysFinanceUserType30ServiceCredits::orderBy('CreditDate', 'desc')->get();

        // ==========================================
        // Fetch This Year Records from Both Tables
        // ==========================================
        $thisYearFeesRecords = SysFinanceUserType30Fees::whereBetween('CreditDate', [$currentYearStart, $currentYearEnd])
            ->orderBy('CreditDate', 'desc')->get();
        $thisYearCreditsRecords = SysFinanceUserType30ServiceCredits::whereBetween('CreditDate', [$currentYearStart, $currentYearEnd])
            ->orderBy('CreditDate', 'desc')->get();

        return view('modules.mod-02.revenue', compact('allTimeRevenue', 'thisYearRevenue', 'dataSource', 'feesRecords', 'creditsRecords', 'thisYearFeesRecords', 'thisYearCreditsRecords'));
    }
}
