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
        Schema::create('sys_workout_assignments', function (Blueprint $table) {
            $table->id('ID');
            $table->unsignedBigInteger('TherapistID')->index();
            $table->unsignedBigInteger('PatientID')->index();
            $table->unsignedBigInteger('ExerciseID')->index();

            $table->unsignedInteger('SetsTarget')->default(3);
            $table->unsignedInteger('RepsTarget')->default(10);
            $table->unsignedInteger('FrequencyPerWeek')->default(3);
            $table->text('TherapistNotes')->nullable();

            $table->date('StartDate')->nullable();
            $table->date('EndDate')->nullable();
            $table->enum('Status', ['active', 'paused', 'completed', 'cancelled'])->default('active');

            $table->timestamps();

            $table->foreign('TherapistID')->references('ID')->on('users')->cascadeOnDelete();
            $table->foreign('PatientID')->references('ID')->on('users')->cascadeOnDelete();
            $table->foreign('ExerciseID')->references('ID')->on('sys_workout_exercises')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_workout_assignments');
    }
};
