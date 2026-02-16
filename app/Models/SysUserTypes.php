<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysUserTypes extends Model
{
    use HasFactory;

    protected $table = 'sys_user_types';

    protected $primaryKey = 'ID';
    public $incrementing = true;
    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'UserTypeRef',
        'UserTypeDescription',
    ];

    protected $casts = [
        'UserTypeRef' => 'integer',
    ];
}