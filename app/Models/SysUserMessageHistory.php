<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysUserMessageHistory extends Model
{
    protected $table = 'sys_user_message_history';
    protected $primaryKey = 'ID';

    protected $fillable = [
        'FromUserID',
        'FromUserType',
        'ToUserID',
        'ToUserType',
        'MessageDateTime',
        'MessageContent',
    ];

    public $timestamps = true;

    protected $casts = [
        'MessageDateTime' => 'datetime',
    ];
}
