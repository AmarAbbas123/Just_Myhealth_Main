<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$faq = \App\Models\SysMenuDisplayOption::find(250);
if ($faq) {
    $faq->Grouping = 'Sys Admin';
    $faq->save();
    echo "Updated FAQ menu item to Sys Admin grouping";
} else {
    echo "FAQ menu item not found";
}