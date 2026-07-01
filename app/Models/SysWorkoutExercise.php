<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysWorkoutExercise extends Model
{
    use HasFactory;

    protected $table = 'sys_workout_exercises';
    protected $primaryKey = 'ID';

    protected $fillable = [
        'CreatedByTherapistID',
        'ExerciseName',
        'ExerciseType',
        'BodyPart',
        'Instructions',
        'AngleRuleConfig',
        'DefaultSets',
        'DefaultReps',
        'VideoDemoPath',
        'IsActive',
    ];

    protected $casts = [
        'AngleRuleConfig' => 'array',
        'IsActive' => 'boolean',
    ];

    public function therapist()
    {
        return $this->belongsTo(User::class, 'CreatedByTherapistID');
    }

    public function assignments()
    {
        return $this->hasMany(SysWorkoutAssignment::class, 'ExerciseID', 'ID');
    }
}
