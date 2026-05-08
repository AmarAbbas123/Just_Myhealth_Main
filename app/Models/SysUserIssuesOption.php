<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysUserIssuesOption extends Model
{
    use HasFactory;

    protected $table = 'sys_user_issues_options';
    protected $primaryKey = 'ID';

    protected $fillable = [
        'ParentID',
        'DisplayName',
        'SendMessageToUser',
        'SendEmailAddress',
        '1',
        '2',
        '10',
        '11',
        '12',
        '13',
        '30',
        '31',
        '32',
        '90',
        '91',
    ];

    protected $casts = [
        'ParentID' => 'integer',
        '1' => 'integer',
        '2' => 'integer',
        '10' => 'integer',
        '11' => 'integer',
        '12' => 'integer',
        '13' => 'integer',
        '30' => 'integer',
        '31' => 'integer',
        '32' => 'integer',
        '90' => 'integer',
        '91' => 'integer',
    ];

    public function parent()
    {
        return $this->belongsTo(self::class, 'ParentID', 'ID');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'ParentID', 'ID');
    }

    public function scopeVisibleForUserType($query, int $userType)
    {
        return $query->where((string) $userType, 1);
    }
}
