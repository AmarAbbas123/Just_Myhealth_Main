<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
function existsTable($name) {
    return Schema::hasTable($name) ? 'yes' : 'no';
}
echo "sys_workout_exercises=" . existsTable('sys_workout_exercises') . "\n";
echo "sessions=" . existsTable('sessions') . "\n";
$migs = ['2025_07_18_065332_rename_standard_user_columns_pascal_case','2025_07_17_152611_modify_users_table_for_profile_data','2026_05_05_155439_create_sessions_table','2026_07_01_100001_create_sys_workout_exercises_table'];
foreach ($migs as $migration) {
    $row = DB::table('migrations')->where('migration', $migration)->first();
    echo $migration . '=' . ($row ? 'ran batch=' . $row->batch : 'pending') . "\n";
}
