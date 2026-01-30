<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$columns = Schema::getColumnListing('reviews');
echo "Columns in 'reviews' table:\n";
foreach ($columns as $column) {
    echo "- $column\n";
}

$columnsReplies = Schema::getColumnListing('review_replies');
echo "\nColumns in 'review_replies' table:\n";
foreach ($columnsReplies as $column) {
    echo "- $column\n";
}
