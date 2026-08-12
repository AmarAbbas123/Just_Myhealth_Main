<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "sys_workout_exercises exists=" . (Schema::hasTable('sys_workout_exercises') ? 'yes' : 'no') . "\n";
echo "users.pending_email exists=" . (Schema::hasColumn('users', 'pending_email') ? 'yes' : 'no') . "\n";
$indexes = DB::select('SHOW INDEX FROM users');
foreach ($indexes as $idx) {
    echo "INDEX: {$idx->Key_name} | COLUMN: {$idx->Column_name} | NON_UNIQUE: {$idx->Non_unique}\n";
}
$migrated = DB::table('migrations')->where('migration', '2025_07_15_120959_add_pending_email_to_users_table')->first();
if ($migrated) {
    echo "migration pending_email status=ran batch={$migrated->batch}\n";
} else {
    echo "migration pending_email status=pending\n";
}
$workout = DB::table('migrations')->where('migration', '2026_07_01_100001_create_sys_workout_exercises_table')->first();
if ($workout) {
    echo "migration workout_exercises status=ran batch={$workout->batch}\n";
} else {
    echo "migration workout_exercises status=pending\n";
}
