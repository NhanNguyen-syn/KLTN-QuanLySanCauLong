<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();
echo "Tables: " . implode(', ', $tables) . "\n\n";

if (in_array('reviews', $tables)) {
    $columns = Schema::getColumnListing('reviews');
    echo "Columns in reviews table: " . implode(', ', $columns) . "\n";
}

if (in_array('products', $tables)) {
    $columns = Schema::getColumnListing('products');
    echo "Columns in products table: " . implode(', ', $columns) . "\n";
}
