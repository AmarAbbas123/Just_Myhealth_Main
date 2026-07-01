<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sys_workout_exercises', function (Blueprint $table) {
            $table->id('ID');
            $table->unsignedBigInteger('CreatedByTherapistID')->index();
            $table->string('ExerciseName');
            // Which built-in AI checker this exercise uses on the frontend
            // e.g. 'knee_squat', 'shoulder_raise', 'elbow_curl', 'generic_angle'
            $table->string('ExerciseType');
            $table->string('BodyPart')->nullable(); // e.g. Knee, Shoulder, Elbow, Hip
            $table->text('Instructions')->nullable();

            // The AI rule config: joints to track + angle thresholds that define
            // "bottom of rep" and "top of rep" + tolerance. Stored as JSON so
            // therapists can tune it per patient without touching code.
            // Example:
            // {
            //   "joint": "knee",           // which angle triplet to use (hip-knee-ankle)
            //   "side": "both",            // left | right | both
            //   "down_angle_max": 100,     // angle must go BELOW this to count "down"
            //   "up_angle_min": 160,       // angle must go ABOVE this to count "up"/rep complete
            //   "good_form_tolerance": 15  // degrees of allowed deviation before flagged as bad form
            // }
            $table->json('AngleRuleConfig');

            $table->unsignedInteger('DefaultSets')->default(3);
            $table->unsignedInteger('DefaultReps')->default(10);
            $table->string('VideoDemoPath')->nullable();
            $table->boolean('IsActive')->default(true);
            $table->timestamps();

            $table->foreign('CreatedByTherapistID')->references('ID')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_workout_exercises');
    }
};
