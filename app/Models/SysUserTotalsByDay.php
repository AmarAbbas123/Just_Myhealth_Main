<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysUserTotalsByDay extends Model
{
    use HasFactory;

    protected $table = 'sys_user_totals_by_day';

    protected $primaryKey = 'ID';
    public $incrementing = true;
    protected $keyType = 'int';

    // Using default Laravel timestamps
    public $timestamps = true;

    protected $fillable = [
        'Date',
        'UserStandard',
        'UserEnhanced',
        'UserDischargedPatient',
        'UserBusinessLocal',
        'UserBusinessRegional',
        'UserBusinessNational',
        'UserBusinessGlobal',
        'UserProfessionalTherapist',
        'UserProfessionalPersonalTrainer',
        'UserProfessionalDietitian',
    ];

    protected $casts = [
        'Date' => 'date',

        'UserStandard' => 'integer',
        'UserEnhanced' => 'integer',
        'UserDischargedPatient' => 'integer',

        'UserBusinessLocal' => 'integer',
        'UserBusinessRegional' => 'integer',
        'UserBusinessNational' => 'integer',
        'UserBusinessGlobal' => 'integer',

        'UserProfessionalTherapist' => 'integer',
        'UserProfessionalPersonalTrainer' => 'integer',
        'UserProfessionalDietitian' => 'integer',
    ];
}