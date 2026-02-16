<?php 


// app/Traits/DeviceLogger.php
namespace App\Traits;

use Jenssegers\Agent\Agent;
use App\Models\SysDeviceDetailsHistory;

class DeviceLogger
{
    public static function log($userId, $userType, $action)
    {
        $agent = new Agent();

        SysDeviceDetailsHistory::create([
            'UserID'        => $userId,
            'UserType'      => $userType,
            'DeviceType'    => $agent->isDesktop() ? 'PC' : ($agent->isTablet() ? 'Tablet' : ($agent->isPhone() ? 'Mobile' : 'Other')),
            'DeviceOS'      => $agent->platform() ?: 'Unknown',
            'DeviceBrowser' => $agent->browser() ?: 'Unknown',
            'UserAction'    => $action,
            'ActivityDateTime' => now(),
        ]);
    }
}
