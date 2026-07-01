<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sys_workout_sessions_ai', function (Blueprint $table) {
            $table->enum('EntryMethod', ['ai_camera', 'manual'])
                ->default('ai_camera')
                ->after('ExerciseID');
        });
    }

    public function down(): void
    {
        Schema::table('sys_workout_sessions_ai', function (Blueprint $table) {
            $table->dropColumn('EntryMethod');
        });
    }
};
