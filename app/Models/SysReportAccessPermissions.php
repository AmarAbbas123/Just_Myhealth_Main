<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysReportAccessPermissions extends Model
{
    use HasFactory;

    protected $table = 'sys_report_access_permissions';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'ReportName',
        'ReportCells',
        'ReportStyle',
        'JMH_Super_Admin_90',
        'JMH_System_Admin_91',
        'JMH_Finance_Admin_92',
        'JMH_Regional_Admin_93',
        'JMH_National_Admin_94',
        'JMH_Group_Admin_95',
        'PRO_Group_Admin_40',
        'PRO_Group_Manager_41',
        'PRO_Group_Team_Leader_42',
        'MED_Group_Admin_20',
        'MED_Group_Manager_21',
        'MED_Group_Team_leader_22',

    ];

   
}
