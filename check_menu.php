<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$items = \App\Models\SysMenuDisplayOption::orderBy('Grouping')->orderBy('ID')->get();
foreach($items as $i) {
    echo $i->ID . ' | ' . $i->DisplayName . ' | ' . $i->Grouping . ' | ' . $i->MenuURL . PHP_EOL;
}