<?php

namespace App\Http\Controllers\Modules\Mod02SystemReporting;

use App\Http\Controllers\Controller;
use App\Models\SysFinanceUserType30Fees;
use App\Models\SysFinanceUserType30ServiceCredits;
use App\Models\SysFinanceUserType31Fees;
use App\Models\SysFinanceUserType32Fees;
use App\Models\SysFinanceUserType10Fees;
use App\Models\SysFinanceUserType11Fees;
use App\Models\SysFinanceUserType12Fees;
use App\Models\SysFinanceUserType13Fees;
use App\Models\SysFinancePlatformOperationCost;
use Illuminate\Support\Facades\Auth;

class FinanceReportsRevenueController extends Controller
{
    /**
     * Only UserType 90 / 91 / 92 allowed
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!in_array(optional(Auth::user())->UserType, [90, 91, 92])) {
                abort(403, 'Unauthorized access');
            }
            return $next($request);
        });
    }

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
        
        // Total Fees (All Time) - Counselling
        $totalFees = SysFinanceUserType30Fees::sum('CreditValue');

        // Total Service Credits (All Time)
        $totalCredits = SysFinanceUserType30ServiceCredits::sum('CreditValue');

        // Additional registration fee tables (All Time)
        $physicalTraining = SysFinanceUserType31Fees::sum('CreditValue');
        $dietitian = SysFinanceUserType32Fees::sum('CreditValue');
        $businessLocal = SysFinanceUserType10Fees::sum('CreditValue');
        $businessRegional = SysFinanceUserType11Fees::sum('CreditValue');
        $businessNational = SysFinanceUserType12Fees::sum('CreditValue');
        $businessGlobal = SysFinanceUserType13Fees::sum('CreditValue');

        // Total Revenue (All Time) including new items
        $allTimeTotal = $totalFees + $totalCredits + $physicalTraining + $dietitian + $businessLocal + $businessRegional + $businessNational + $businessGlobal;

        // ==========================================
        // THIS YEAR REVENUE
        // ==========================================
        
        // This Year Fees (Counselling)
        $thisYearFees = SysFinanceUserType30Fees::whereBetween('CreditDate', [$currentYearStart, $currentYearEnd])
            ->sum('CreditValue');

        // This Year Service Credits
        $thisYearCredits = SysFinanceUserType30ServiceCredits::whereBetween('CreditDate', [$currentYearStart, $currentYearEnd])
            ->sum('CreditValue');

        // This Year additional registration fee tables
        $thisYearPhysicalTraining = SysFinanceUserType31Fees::whereBetween('CreditDate', [$currentYearStart, $currentYearEnd])->sum('CreditValue');
        $thisYearDietitian = SysFinanceUserType32Fees::whereBetween('CreditDate', [$currentYearStart, $currentYearEnd])->sum('CreditValue');
        $thisYearBusinessLocal = SysFinanceUserType10Fees::whereBetween('CreditDate', [$currentYearStart, $currentYearEnd])->sum('CreditValue');
        $thisYearBusinessRegional = SysFinanceUserType11Fees::whereBetween('CreditDate', [$currentYearStart, $currentYearEnd])->sum('CreditValue');
        $thisYearBusinessNational = SysFinanceUserType12Fees::whereBetween('CreditDate', [$currentYearStart, $currentYearEnd])->sum('CreditValue');
        $thisYearBusinessGlobal = SysFinanceUserType13Fees::whereBetween('CreditDate', [$currentYearStart, $currentYearEnd])->sum('CreditValue');

        // This Year Total Revenue including new items
        $thisYearTotal = $thisYearFees + $thisYearCredits + $thisYearPhysicalTraining + $thisYearDietitian + $thisYearBusinessLocal + $thisYearBusinessRegional + $thisYearBusinessNational + $thisYearBusinessGlobal;

        // ==========================================
        // Prepare Data for View
        // ==========================================
        
        $allTimeRevenue = [
            'total' => 'GBP: £' . number_format($allTimeTotal, 2),
            'registration_fees' => 'GBP: £' . number_format($totalFees, 2),
            'session_fees' => 'GBP: £' . number_format($totalCredits, 2),
            'physical_training_registration' => 'GBP: £' . number_format($physicalTraining, 2),
            'dietitian_registration' => 'GBP: £' . number_format($dietitian, 2),
            'business_local_registration' => 'GBP: £' . number_format($businessLocal, 2),
            'business_regional_registration' => 'GBP: £' . number_format($businessRegional, 2),
            'business_national_registration' => 'GBP: £' . number_format($businessNational, 2),
            'business_global_registration' => 'GBP: £' . number_format($businessGlobal, 2),
        ];

        $thisYearRevenue = [
            'total' => 'GBP: £' . number_format($thisYearTotal, 2),
            'registration_fees' => 'GBP: £' . number_format($thisYearFees, 2),
            'session_fees' => 'GBP: £' . number_format($thisYearCredits, 2),
            'physical_training_registration' => 'GBP: £' . number_format($thisYearPhysicalTraining, 2),
            'dietitian_registration' => 'GBP: £' . number_format($thisYearDietitian, 2),
            'business_local_registration' => 'GBP: £' . number_format($thisYearBusinessLocal, 2),
            'business_regional_registration' => 'GBP: £' . number_format($thisYearBusinessRegional, 2),
            'business_national_registration' => 'GBP: £' . number_format($thisYearBusinessNational, 2),
            'business_global_registration' => 'GBP: £' . number_format($thisYearBusinessGlobal, 2),
        ];

        // ==========================================
        // Raw Values for Data Source Display
        // ==========================================
        $dataSource = [
            'all_time' => [
                'fees_table' => $totalFees,
                'credits_table' => $totalCredits,
                'physical_training' => $physicalTraining,
                'dietitian' => $dietitian,
                'business_local' => $businessLocal,
                'business_regional' => $businessRegional,
                'business_national' => $businessNational,
                'business_global' => $businessGlobal,
                'total_calculation' => ($totalFees + $totalCredits + $physicalTraining + $dietitian + $businessLocal + $businessRegional + $businessNational + $businessGlobal)
            ],
            'this_year' => [
                'fees_table' => $thisYearFees,
                'credits_table' => $thisYearCredits,
                'physical_training' => $thisYearPhysicalTraining,
                'dietitian' => $thisYearDietitian,
                'business_local' => $thisYearBusinessLocal,
                'business_regional' => $thisYearBusinessRegional,
                'business_national' => $thisYearBusinessNational,
                'business_global' => $thisYearBusinessGlobal,
                'total_calculation' => ($thisYearFees + $thisYearCredits + $thisYearPhysicalTraining + $thisYearDietitian + $thisYearBusinessLocal + $thisYearBusinessRegional + $thisYearBusinessNational + $thisYearBusinessGlobal)
            ]
        ];

        // ==========================================
        // Fetch All Records from Relevant Tables
        // ==========================================
        $feesRecords = SysFinanceUserType30Fees::orderBy('CreditDate', 'desc')->get();
        $creditsRecords = SysFinanceUserType30ServiceCredits::orderBy('CreditDate', 'desc')->get();
        $physicalTrainingRecords = SysFinanceUserType31Fees::orderBy('CreditDate', 'desc')->get();
        $dietitianRecords = SysFinanceUserType32Fees::orderBy('CreditDate', 'desc')->get();
        $businessLocalRecords = SysFinanceUserType10Fees::orderBy('CreditDate', 'desc')->get();
        $businessRegionalRecords = SysFinanceUserType11Fees::orderBy('CreditDate', 'desc')->get();
        $businessNationalRecords = SysFinanceUserType12Fees::orderBy('CreditDate', 'desc')->get();
        $businessGlobalRecords = SysFinanceUserType13Fees::orderBy('CreditDate', 'desc')->get();

        // ==========================================
        // Fetch This Year Records from Relevant Tables
        // ==========================================
        $thisYearFeesRecords = SysFinanceUserType30Fees::whereBetween('CreditDate', [$currentYearStart, $currentYearEnd])
            ->orderBy('CreditDate', 'desc')->get();
        $thisYearCreditsRecords = SysFinanceUserType30ServiceCredits::whereBetween('CreditDate', [$currentYearStart, $currentYearEnd])
            ->orderBy('CreditDate', 'desc')->get();
        $thisYearPhysicalTrainingRecords = SysFinanceUserType31Fees::whereBetween('CreditDate', [$currentYearStart, $currentYearEnd])
            ->orderBy('CreditDate', 'desc')->get();
        $thisYearDietitianRecords = SysFinanceUserType32Fees::whereBetween('CreditDate', [$currentYearStart, $currentYearEnd])
            ->orderBy('CreditDate', 'desc')->get();
        $thisYearBusinessLocalRecords = SysFinanceUserType10Fees::whereBetween('CreditDate', [$currentYearStart, $currentYearEnd])
            ->orderBy('CreditDate', 'desc')->get();
        $thisYearBusinessRegionalRecords = SysFinanceUserType11Fees::whereBetween('CreditDate', [$currentYearStart, $currentYearEnd])
            ->orderBy('CreditDate', 'desc')->get();
        $thisYearBusinessNationalRecords = SysFinanceUserType12Fees::whereBetween('CreditDate', [$currentYearStart, $currentYearEnd])
            ->orderBy('CreditDate', 'desc')->get();
        $thisYearBusinessGlobalRecords = SysFinanceUserType13Fees::whereBetween('CreditDate', [$currentYearStart, $currentYearEnd])
            ->orderBy('CreditDate', 'desc')->get();

        return view('modules.mod-02.finance-reports.revenue', compact(
            'allTimeRevenue',
            'thisYearRevenue',
            'dataSource',
            'feesRecords',
            'creditsRecords',
            'physicalTrainingRecords',
            'dietitianRecords',
            'businessLocalRecords',
            'businessRegionalRecords',
            'businessNationalRecords',
            'businessGlobalRecords',
            'thisYearFeesRecords',
            'thisYearCreditsRecords',
            'thisYearPhysicalTrainingRecords',
            'thisYearDietitianRecords',
            'thisYearBusinessLocalRecords',
            'thisYearBusinessRegionalRecords',
            'thisYearBusinessNationalRecords',
            'thisYearBusinessGlobalRecords'
        ));
    }

    /**
     * Display Platform Operations Costs report
     */
    public function paymentsPlatformOperations()
    {
        $currentYear = date('Y');
        $currentYearStart = "{$currentYear}-01-01";
        $currentYearEnd = "{$currentYear}-12-31";

        // All time total
        $allTimeTotal = SysFinancePlatformOperationCost::sum('DebitValue') ?: 0;

        // This year total
        $thisYearTotal = SysFinancePlatformOperationCost::whereBetween('DebitDate', [$currentYearStart, $currentYearEnd])->sum('DebitValue') ?: 0;

        // Breakdown by ServiceCategory (all time)
        $categoriesAll = SysFinancePlatformOperationCost::selectRaw('ServiceCategory, SUM(DebitValue) as total')
            ->groupBy('ServiceCategory')
            ->pluck('total', 'ServiceCategory')
            ->toArray();

        // Breakdown by ServiceCategory (this year)
        $categoriesThisYear = SysFinancePlatformOperationCost::selectRaw('ServiceCategory, SUM(DebitValue) as total')
            ->whereBetween('DebitDate', [$currentYearStart, $currentYearEnd])
            ->groupBy('ServiceCategory')
            ->pluck('total', 'ServiceCategory')
            ->toArray();

        // Ensure known categories exist in arrays
        $known = ['Compute', 'Services Plugins', 'SW Dev', 'SW Support', 'Security Services', 'Misc'];
        $allTime = ['total' => 'GBP: £' . number_format($allTimeTotal, 2)];
        $thisYear = ['total' => 'GBP: £' . number_format($thisYearTotal, 2)];

        foreach ($known as $k) {
            $allTimeKey = strtolower(str_replace(' ', '_', $k));
            $thisYearKey = $allTimeKey;
            $allTime[$allTimeKey] = 'GBP: £' . number_format($categoriesAll[$k] ?? 0, 2);
            $thisYear[$thisYearKey] = 'GBP: £' . number_format($categoriesThisYear[$k] ?? 0, 2);
        }

        // Raw data source for potential charts
        $dataSource = [
            'all_time' => array_merge(['total' => $allTimeTotal], $categoriesAll),
            'this_year' => array_merge(['total' => $thisYearTotal], $categoriesThisYear),
        ];

        // Fetch records for table display
        $recordsAll = SysFinancePlatformOperationCost::orderBy('DebitDate', 'desc')->get();
        $recordsThisYear = SysFinancePlatformOperationCost::whereBetween('DebitDate', [$currentYearStart, $currentYearEnd])->orderBy('DebitDate', 'desc')->get();

        return view('modules.mod-02.finance-reports.payments-platform-operations', compact(
            'allTime',
            'thisYear',
            'dataSource',
            'recordsAll',
            'recordsThisYear'
        ));
    }
}