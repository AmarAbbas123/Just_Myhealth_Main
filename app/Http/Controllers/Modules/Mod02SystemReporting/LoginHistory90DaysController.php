<?php

namespace App\Http\Controllers\Modules\Mod02SystemReporting;

use App\Http\Controllers\Controller;
use App\Models\SysDeviceDetailsHistory;
use App\Models\SysUserTypes;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginHistory90DaysController extends Controller
{
    public function index()
    {
        $userTypes = SysUserTypes::orderBy('UserTypeRef')->get(['UserTypeRef', 'UserTypeDescription']);

        return view('modules.mod-02.user-reports.login-history-90days', compact('userTypes'));
    }

    public function users($userTypeRef)
    {
        $users = User::where('UserType', $userTypeRef)
            ->orderBy('UserName')
            ->get(['ID', 'UserName']);

        return response()->json($users);
    }

    public function data(Request $request)
    {
        $userId = (int) $request->query('userId');

        if (!$userId) {
            return response()->json([
                'dates' => [],
                'loginCounts' => [],
                'deviceTypeSeries' => [],
            ]);
        }

        $end = Carbon::now()->endOfDay();
        $start = Carbon::now()->subDays(89)->startOfDay();

        $dates = collect();
        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $dates->push($date->format('Y-m-d'));
        }

        $loginRows = SysDeviceDetailsHistory::select(
            DB::raw('DATE(ActivityDateTime) as date'),
            DB::raw('COUNT(*) as total')
        )
            ->where('UserAction', 'Login')
            ->where('UserID', $userId)
            ->whereBetween('ActivityDateTime', [$start, $end])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();

        $loginCounts = $dates->map(fn($date) => (int) ($loginRows[$date] ?? 0))->toArray();

        $deviceRows = SysDeviceDetailsHistory::select(
            DB::raw('DATE(ActivityDateTime) as date'),
            'DeviceType',
            DB::raw('COUNT(*) as total')
        )
            ->where('UserAction', 'Login')
            ->where('UserID', $userId)
            ->whereBetween('ActivityDateTime', [$start, $end])
            ->whereNotNull('DeviceType')
            ->groupBy('date', 'DeviceType')
            ->orderBy('date')
            ->get();

        $deviceOsRows = SysDeviceDetailsHistory::select(
            DB::raw('DATE(ActivityDateTime) as date'),
            'DeviceOS',
            DB::raw('COUNT(*) as total')
        )
            ->where('UserAction', 'Login')
            ->where('UserID', $userId)
            ->whereBetween('ActivityDateTime', [$start, $end])
            ->whereNotNull('DeviceOS')
            ->groupBy('date', 'DeviceOS')
            ->orderBy('date')
            ->get();

        $deviceBrowserRows = SysDeviceDetailsHistory::select(
            DB::raw('DATE(ActivityDateTime) as date'),
            'DeviceBrowser',
            DB::raw('COUNT(*) as total')
        )
            ->where('UserAction', 'Login')
            ->where('UserID', $userId)
            ->whereBetween('ActivityDateTime', [$start, $end])
            ->whereNotNull('DeviceBrowser')
            ->groupBy('date', 'DeviceBrowser')
            ->orderBy('date')
            ->get();

        $deviceTypes = $deviceRows->pluck('DeviceType')->unique()->sort()->values()->toArray();
        $deviceOsTypes = $deviceOsRows->pluck('DeviceOS')->unique()->sort()->values()->toArray();
        $deviceBrowserTypes = $deviceBrowserRows->pluck('DeviceBrowser')->unique()->sort()->values()->toArray();

        $deviceLookup = $deviceRows->mapWithKeys(function ($row) {
            return ["{$row->date}|{$row->DeviceType}" => (int) $row->total];
        });

        $deviceOsLookup = $deviceOsRows->mapWithKeys(function ($row) {
            return ["{$row->date}|{$row->DeviceOS}" => (int) $row->total];
        });

        $deviceBrowserLookup = $deviceBrowserRows->mapWithKeys(function ($row) {
            return ["{$row->date}|{$row->DeviceBrowser}" => (int) $row->total];
        });

        $deviceSeries = array_map(function ($deviceType) use ($dates, $deviceLookup) {
            $values = $dates->map(function ($date) use ($deviceLookup, $deviceType) {
                return $deviceLookup["{$date}|{$deviceType}"] ?? 0;
            })->toArray();

            return [
                'name' => $deviceType,
                'data' => $values,
            ];
        }, $deviceTypes);

        $osSeries = array_map(function ($deviceOs) use ($dates, $deviceOsLookup) {
            $values = $dates->map(function ($date) use ($deviceOsLookup, $deviceOs) {
                return $deviceOsLookup["{$date}|{$deviceOs}"] ?? 0;
            })->toArray();

            return [
                'name' => $deviceOs,
                'data' => $values,
            ];
        }, $deviceOsTypes);

        $browserSeries = array_map(function ($deviceBrowser) use ($dates, $deviceBrowserLookup) {
            $values = $dates->map(function ($date) use ($deviceBrowserLookup, $deviceBrowser) {
                return $deviceBrowserLookup["{$date}|{$deviceBrowser}"] ?? 0;
            })->toArray();

            return [
                'name' => $deviceBrowser,
                'data' => $values,
            ];
        }, $deviceBrowserTypes);

        return response()->json([
            'dates' => $dates->map(fn($date) => Carbon::parse($date)->format('d M'))->toArray(),
            'loginCounts' => $loginCounts,
            'deviceTypeSeries' => $deviceSeries,
            'deviceOsSeries' => $osSeries,
            'deviceBrowserSeries' => $browserSeries,
        ]);
    }
}
