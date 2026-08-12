<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Support\Facades\Schema;

if (! Schema::hasTable('blog_posts')) {
    echo "blog_posts table missing\n";
    exit(0);
}
$cols = Schema::getColumnListing('blog_posts');
echo implode(',', $cols) . "\n";
