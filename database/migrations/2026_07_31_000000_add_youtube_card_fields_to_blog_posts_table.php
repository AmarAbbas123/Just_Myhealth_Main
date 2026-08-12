<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $columnsToAdd = [];
        if (! Schema::hasColumn('blog_posts', 'VideoTitle')) {
            $columnsToAdd[] = 'VideoTitle';
        }
        if (! Schema::hasColumn('blog_posts', 'VideoDescription')) {
            $columnsToAdd[] = 'VideoDescription';
        }

        if (count($columnsToAdd) > 0) {
            Schema::table('blog_posts', function (Blueprint $table) use ($columnsToAdd) {
                if (in_array('VideoTitle', $columnsToAdd, true)) {
                    $table->string('VideoTitle')->nullable()->after('VideoUrl');
                }
                if (in_array('VideoDescription', $columnsToAdd, true)) {
                    $table->text('VideoDescription')->nullable()->after('VideoTitle');
                }
            });
        }
    }

    public function down(): void
    {
        $columnsToDrop = [];
        if (Schema::hasColumn('blog_posts', 'VideoTitle')) {
            $columnsToDrop[] = 'VideoTitle';
        }
        if (Schema::hasColumn('blog_posts', 'VideoDescription')) {
            $columnsToDrop[] = 'VideoDescription';
        }

        if (count($columnsToDrop) > 0) {
            Schema::table('blog_posts', function (Blueprint $table) use ($columnsToDrop) {
                $table->dropColumn($columnsToDrop);
            });
        }
    }
};
