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
        Schema::create('sys_workout_sessions_ai', function (Blueprint $table) {
            $table->id('ID');
            $table->unsignedBigInteger('AssignmentID')->index();
            $table->unsignedBigInteger('PatientID')->index();
            $table->unsignedBigInteger('ExerciseID')->index();

            $table->dateTime('AttemptedAt');
            $table->unsignedInteger('DurationSeconds')->default(0);

            $table->unsignedInteger('RepsCompleted')->default(0);
            $table->unsignedInteger('RepsGoodForm')->default(0);
            $table->unsignedInteger('RepsBadForm')->default(0);
            $table->unsignedTinyInteger('AvgFormScore')->default(0); // 0-100

            // Per-rep breakdown captured client-side by the AI checker:
            // [{ "rep": 1, "angle_min": 78, "angle_max": 172, "verdict": "good", "note": "" }, ...]
            $table->json('RepDetails')->nullable();

            $table->timestamps();

            $table->foreign('AssignmentID')->references('ID')->on('sys_workout_assignments')->cascadeOnDelete();
            $table->foreign('PatientID')->references('ID')->on('users')->cascadeOnDelete();
            $table->foreign('ExerciseID')->references('ID')->on('sys_workout_exercises')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_workout_sessions_ai');
    }
};
