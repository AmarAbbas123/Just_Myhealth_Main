<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysUserType30SessionHistory extends Model
{
    use HasFactory;

    protected $table = 'sys_user_type_30_session_history';
    protected $primaryKey = 'ID';
    public $timestamps = false;

    protected $fillable = [
        'UserID',
        'PatientUserID',
        'AllocatedTherapistUserID',
        'SessionCalendarID',
        'SessionBookedDate',
        'PatientEnteredWaitingRoomDate',
        'PatientEnteredWaitingRoomTime',
        'TherapistEnteredWaitingRoomDate',
        'TherapistEnteredWaitingRoomTime',
        'SessionStartedDate',
        'SessionStartedTime',
        'SessionEndedDate',
        'SessionEndedTime',
        'TherapistNotes',
        'SessionNotesResource1',
        'SessionNotesResource2',
        'SessionNotesResource3',
        'SessionNotesResource4',
        'SessionNotesResources1',
        'SessionNotesResources2',
        'SessionNotesResources3',
        'SessionNotesResources4',
        'SessionZegoCloudConnectID',
        'zego_task_id',
        'LinkToSessionRecording',
        'SessionMediaType',
        'PlatformFee',
        'SessionBlockRevenue',
        'NumberOfPurchasedSessions',
        'RevenueForSession',
        'TherapistPaymentValue',
        'TherapistPaymentCompleted'
    ];

    // Relationship helpers
    public function therapist()
    {
        return $this->belongsTo(User::class, 'AllocatedTherapistUserID', 'ID');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'PatientUserID', 'ID');
    }
}
