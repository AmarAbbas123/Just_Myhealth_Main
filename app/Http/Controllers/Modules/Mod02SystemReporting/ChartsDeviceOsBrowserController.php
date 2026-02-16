<?php

namespace App\Http\Controllers\Modules\Mod02SystemReporting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SysDeviceDetailsHistory;

class ChartsDeviceOsBrowserController extends Controller
{

    public function index()
    {
        return view('modules.mod-02.user-reports.device-os-browser');
    }

    public function data()
    {
        return response()->json([
            'userType'      => $this->chartData('UserType'),
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
