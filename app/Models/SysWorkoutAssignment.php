<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysWorkoutAssignment extends Model
{
    use HasFactory;

    protected $table = 'sys_workout_assignments';
    protected $primaryKey = 'ID';

    protected $fillable = [
        'TherapistID',
        'PatientID',
        'ExerciseID',
        'SetsTarget',
        'RepsTarget',
        'FrequencyPerWeek',
        'TherapistNotes',
        'StartDate',
        'EndDate',
        'Status',
    ];

    public function therapist()
    {
        return $this->belongsTo(User::class, 'TherapistID');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'PatientID');
    }

    public function exercise()
    {
        return $this->belongsTo(SysWorkoutExercise::class, 'ExerciseID', 'ID');
    }

    public function sessions()
    {
        return $this->hasMany(SysWorkoutSessionAi::class, 'AssignmentID', 'ID');
    }
}
