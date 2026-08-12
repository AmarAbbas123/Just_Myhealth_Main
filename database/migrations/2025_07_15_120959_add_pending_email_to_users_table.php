<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'pending_email')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('pending_email')->nullable()->after('email');
            });
        }

        $indexExists = DB::select(
            "SHOW INDEX FROM users WHERE Key_name = ?",
            ['users_pending_email_unique']
        );

        if (empty($indexExists)) {
            Schema::table('users', function (Blueprint $table) {
                $table->unique('pending_email');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('pending_email');
        });
    }
};
