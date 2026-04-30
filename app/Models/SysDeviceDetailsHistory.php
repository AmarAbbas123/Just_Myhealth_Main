<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysDeviceDetailsHistory extends Model
{
    use HasFactory;

    protected $table = 'sys_device_details_history';
    protected $primaryKey = 'ID';
    public $timestamps = false;   //  Add this line

    protected $fillable = [
        'UserID',
        'UserType',
        'DeviceType',
        'DeviceOS', 
        'DeviceBrowser',
        'UserAction',
        'ActivityDateTime',
    ];

protected $casts = [
    'DeviceType'       => 'string',
    'DeviceOS'         => 'string',
    'DeviceBrowser'    => 'string',
    'UserAction'       => 'string',
    'ActivityDateTime' => 'datetime',
];

  
  
    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'ID');
    }
}
