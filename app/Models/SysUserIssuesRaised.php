<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysUserIssuesRaised extends Model
{
    use HasFactory;

    protected $table = 'sys_user_issues_raised';
    protected $primaryKey = 'ID';

    protected $fillable = [
        'PatientUserID',
        'DateRaised',
        'TimeRaised',
        'UserType',
        'PrimaryGroupRef',
        'SecondaryGroupRef',
        'IssueConcernEnteredText',
        'IssueStatus',
    ];

    protected $casts = [
        'PatientUserID' => 'integer',
        'DateRaised' => 'date',
        'UserType' => 'integer',
        'PrimaryGroupRef' => 'integer',
        'SecondaryGroupRef' => 'integer',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'PatientUserID', 'ID');
    }

    public function primaryGroup()
    {
        return $this->belongsTo(SysUserIssuesOption::class, 'PrimaryGroupRef', 'ID');
    }

    public function secondaryGroup()
    {
        return $this->belongsTo(SysUserIssuesOption::class, 'SecondaryGroupRef', 'ID');
    }
}
