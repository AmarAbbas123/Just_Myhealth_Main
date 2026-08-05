<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blog_comments', function (Blueprint $table) {
            $table->unsignedBigInteger('UserID')->nullable()->change();
            $table->string('GuestName', 100)->nullable()->after('UserID');
        });
    }

    public function down(): void
    {
        Schema::table('blog_comments', function (Blueprint $table) {
            $table->dropColumn('GuestName');
            $table->unsignedBigInteger('UserID')->nullable(false)->change();
        });
    }
};
