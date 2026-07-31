<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->string('VideoTitle')->nullable()->after('VideoUrl');
            $table->text('VideoDescription')->nullable()->after('VideoTitle');
        });
    }

    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn(['VideoTitle', 'VideoDescription']);
        });
    }
};
