<?php
use Illuminate\Support\Facades\DB;

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Email Settings ===\n";
$settings = DB::table('settings')
    ->where('key', 'like', '%email%')
    ->pluck('value', 'key');
    
foreach ($settings as $key => $value) {
    echo "$key => $value\n";
}

echo "\n=== Template Enabled Check ===\n";
echo "admin-reply enabled: " . (get_setting_email_status('plugins', 'contact', 'admin-reply') ? 'true' : 'false') . "\n";
