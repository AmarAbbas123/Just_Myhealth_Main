<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
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
