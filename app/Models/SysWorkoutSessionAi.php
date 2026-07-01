<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysWorkoutSessionAi extends Model
{
    use HasFactory;

    protected $table = 'sys_workout_sessions_ai';
    protected $primaryKey = 'ID';

    protected $fillable = [
        'AssignmentID',
        'PatientID',
        'ExerciseID',
        'EntryMethod',
        'AttemptedAt',
        'DurationSeconds',
        'RepsCompleted',
        'RepsGoodForm',
        'RepsBadForm',
        'AvgFormScore',
        'RepDetails',
    ];

    protected $casts = [
        'RepDetails' => 'array',
        'AttemptedAt' => 'datetime',
    ];

    public function assignment()
    {
        return $this->belongsTo(SysWorkoutAssignment::class, 'AssignmentID', 'ID');
    }

    public function exercise()
    {
        return $this->belongsTo(SysWorkoutExercise::class, 'ExerciseID', 'ID');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'PatientID');
    }
}
