<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysUserAttribute extends Model
{
    use HasFactory;

    protected $table = 'sys_user_attributes';
    protected $primaryKey = 'ID';

    protected $fillable = [
        'UserID',
        'FirstName',
        'LastName',
        'DOB',
        'YearBirth',
        'Gender',
        'BaseCity',
        'BaseState',
        'BaseCountry',
        'UserHomeTimeZoneName',
        'BusinessName',
        'BusinessContactFirstName',
        'BusinessContactLastName',
        'BusinessPrimaryIndustry',
        'BusinessSubIndustry',
        'BusinessType',
        'Address1',
        'Address2',
        'BaseZip',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'ID');
    }
}
