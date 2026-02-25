<?php

namespace App\Http\Controllers\Modules\Mod02SystemReporting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SysDeviceDetailsHistory;
use App\Models\SysUserTypes;

class ChartsDeviceOsBrowserController extends Controller
{

    public function index()
    {
        return view('modules.mod-02.user-reports.device-os-browser');
    }

    public function data()
    {
        // Base datasets
        $userTypeData = $this->chartData('UserType');

        // Map numeric user type codes to human-readable descriptions
        $userTypeMap = SysUserTypes::pluck('UserTypeDescription', 'UserTypeRef')->toArray();
        $userTypeData['labels'] = collect($userTypeData['labels'])
            ->map(fn($code) => $userTypeMap[$code] ?? (string) $code)
            ->toArray();

        return response()->json([
            'userType'      => $userTypeData,
            'deviceType'    => $this->chartData('DeviceType'),
            'deviceOS'      => $this->chartData('DeviceOS'),
            'deviceBrowser' => $this->chartData('DeviceBrowser'),
        ]);
    }

    private function chartData(string $column)
    {
        $rows = SysDeviceDetailsHistory::select(
            $column,
            DB::raw('COUNT(DISTINCT UserID) as total')
        )
            ->whereNotNull($column)
            ->groupBy($column)
            ->get();

        return [
            'labels' => $rows->pluck($column),
            'series' => $rows->pluck('total'),
        ];
    }
}