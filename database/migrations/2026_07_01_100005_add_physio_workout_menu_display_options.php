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
        // This application has long used this table as a shared menu registry,
        // but older installations received it through a database import rather
        // than a Laravel migration. Create the registry when starting from an
        // empty database so the menu records below can be safely inserted.
        if (! Schema::hasTable('sys_menu_display_options')) {
            Schema::create('sys_menu_display_options', function (Blueprint $table) {
                $table->id('ID');
                $table->unsignedBigInteger('ParentID')->default(0)->index();
                $table->string('DisplayName')->nullable();
                $table->unsignedBigInteger('MainPaneID')->nullable();
                $table->string('MainPaneLabel')->nullable();
                $table->string('TileText')->nullable();
                $table->string('Grouping')->nullable();
                $table->boolean('1')->default(false);
                $table->boolean('10')->default(false);
                $table->boolean('30')->default(false);
                $table->boolean('31')->default(false);
                $table->boolean('32')->default(false);
                $table->boolean('90')->default(false);
                $table->boolean('91')->default(false);
                $table->string('MenuURL')->nullable()->index();
                $table->string('ImagePath')->nullable();
            });
        }

        $this->upsertMenuOption(
            displayName: 'Exercise Library',
            menuUrl: '/mod-10/02/exercise-library',
            patientFlag: 0,
            therapistFlag: 1
        );

        $this->upsertMenuOption(
            displayName: 'My Workouts',
            menuUrl: '/mod-10/02/usr-my-workouts',
            patientFlag: 1,
            therapistFlag: 0
        );

        $this->upsertMenuOption(
            displayName: 'Patient Progress',
            menuUrl: '/mod-10/02/exercise-library',
            patientFlag: 0,
            therapistFlag: 1
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('sys_menu_display_options')) {
            return;
        }

        DB::table('sys_menu_display_options')
            ->whereIn('MenuURL', [
                '/mod-10/02/exercise-library',
                '/mod-10/02/usr-my-workouts',
            ])
            ->delete();
    }

    private function upsertMenuOption(
        string $displayName,
        string $menuUrl,
        int $patientFlag,
        int $therapistFlag
    ): void {
        $updated = DB::update(
            'UPDATE sys_menu_display_options
                SET ParentID = ?,
                    DisplayName = ?,
                    MainPaneID = ?,
                    MainPaneLabel = ?,
                    TileText = ?,
                    Grouping = ?,
                    `1` = ?,
                    `10` = ?,
                    `30` = ?,
                    `31` = ?,
                    `32` = ?,
                    `90` = ?,
                    `91` = ?,
                    ImagePath = ?
              WHERE MenuURL = ?',
            [
                0,
                $displayName,
                null,
                null,
                null,
                null,
                $patientFlag,
                0,
                $therapistFlag,
                0,
                0,
                0,
                0,
                null,
                $menuUrl,
            ]
        );

        if ($updated > 0) {
            return;
        }

        DB::insert(
            'INSERT INTO sys_menu_display_options
                (ParentID, DisplayName, MainPaneID, MainPaneLabel, TileText, Grouping,
                 `1`, `10`, `30`, `31`, `32`, `90`, `91`, MenuURL, ImagePath)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [
                0,
                $displayName,
                null,
                null,
                null,
                null,
                $patientFlag,
                0,
                $therapistFlag,
                0,
                0,
                0,
                0,
                $menuUrl,
                null,
            ]
        );
    }
};
