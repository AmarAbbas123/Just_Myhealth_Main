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
    ->where('DisplayName', 'My Workouts')
    ->orWhere('MenuURL', 'like', '%usr-my-workouts%')
    ->orderBy('ID')
    ->get();

echo "ROWS=" . count($rows) . "\n";
foreach ($rows as $row) {
    echo "ID={$row->ID} ParentID={$row->ParentID} DisplayName={$row->DisplayName} MenuURL={$row->MenuURL} 1={$row->{'1'}} 10={$row->{'10'}} 30={$row->{'30'}} 90={$row->{'90'}}\n";
}
