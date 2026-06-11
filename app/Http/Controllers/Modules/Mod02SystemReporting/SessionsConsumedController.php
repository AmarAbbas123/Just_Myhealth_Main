<?php

namespace App\Http\Controllers\Modules\Mod02SystemReporting;

use App\Http\Controllers\Controller;
use App\Models\SysUserType30SessionHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SessionsConsumedController extends Controller
{
    public function index()
    {
        $endDate = Carbon::now()->endOfDay();
        $startDate = Carbon::now()->subDays(29)->startOfDay();

        $dailyDates = collect();
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dailyDates->push($date->toDateString());
        }

        $dailyLabels = $dailyDates->map(fn($date) => Carbon::parse($date)->format('d M'));

        $dailyCounts = SysUserType30SessionHistory::query()
            ->select(DB::raw('SessionStartedDate as date'), DB::raw('COUNT(*) as total'))
            ->whereNotNull('SessionStartedDate')
            ->whereBetween('SessionStartedDate', [$startDate->toDateString(), $endDate->toDateString()])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();

        $dailyData = $dailyDates->map(fn($date) => (int) ($dailyCounts[$date] ?? 0))->toArray();

        $weekStart = Carbon::now()->subDays(364)->startOfWeek(Carbon::MONDAY);
        $weeklyWeekStarts = collect();
        for ($week = $weekStart->copy(); $week->lte($endDate); $week->addWeek()) {
            $weeklyWeekStarts->push($week->toDateString());
        }

        $weeklyLabels = $weeklyWeekStarts->map(fn($date) => Carbon::parse($date)->format('d M'));

        $weekCounts = [];
        $weeklyRows = SysUserType30SessionHistory::query()
            ->select('SessionStartedDate')
            ->whereNotNull('SessionStartedDate')
            ->whereBetween('SessionStartedDate', [$weekStart->toDateString(), $endDate->toDateString()])
            ->get();

        foreach ($weeklyRows as $row) {
            $weekKey = Carbon::parse($row->SessionStartedDate)
                ->startOfWeek(Carbon::MONDAY)
                ->toDateString();

            $weekCounts[$weekKey] = ($weekCounts[$weekKey] ?? 0) + 1;
        }

        $weeklyData = $weeklyWeekStarts->map(fn($date) => (int) ($weekCounts[$date] ?? 0))->toArray();

        return view('modules.mod-02.counseling-reports.sessions-consumed', [
            'dailyLabels' => $dailyLabels->toArray(),
            'dailyData' => $dailyData,
            'weeklyLabels' => $weeklyLabels->toArray(),
            'weeklyData' => $weeklyData,
        ]);
    }
}
