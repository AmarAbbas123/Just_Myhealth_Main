<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

if (! Schema::hasTable('sys_menu_display_options')) {
    echo "NO_TABLE\n";
    exit(0);
}
$rows = DB::table('sys_menu_display_options')
    ->whereIn('DisplayName', ['My Workouts', 'Wellness Services', 'Physio Workouts', 'Exercise Library'])
    ->orWhere('MenuURL', 'like', '%workout%')
    ->orderBy('ParentID')
    ->orderBy('DisplayName')
    ->get();

foreach ($rows as $r) {
    echo json_encode($r) . "\n";
}
