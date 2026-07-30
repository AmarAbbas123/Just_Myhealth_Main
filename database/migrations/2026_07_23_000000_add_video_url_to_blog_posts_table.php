<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            // A YouTube/Vimeo link embeds directly in the post.
            // Any other URL (e.g. a Facebook video) renders as a
            // "Watch the video" button that opens in a new tab instead.
            $table->string('VideoUrl')->nullable()->after('SourceUrl');
        });
    }

    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn('VideoUrl');
        });
    }
};