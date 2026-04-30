<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysUserType30TasksAction extends Model
{
    use HasFactory;

    protected $table = 'sys_user_type_30_tasks_actions';
    protected $primaryKey = 'ID';
    public $timestamps = true;

    protected $fillable = [
        'TherapistUserID',
        'PatientUserID',
        'TaskTitle',
        'TaskNotes',
        'TaskAssignedTo',
        'DueDate',
        'TaskPrioity',
        'TaskStatus',
    ];

    public function therapist()
    {
        return $this->belongsTo(User::class, 'TherapistUserID', 'ID');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'PatientUserID', 'ID');
    }
}
