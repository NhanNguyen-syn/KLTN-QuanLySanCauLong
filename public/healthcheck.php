<?php
// Health check diagnostic - shows PHP, DB, and Laravel status
// Access via: https://sancaulongnienthoi.onrender.com/healthcheck.php

header('Content-Type: text/plain; charset=utf-8');

echo "=== HEALTH CHECK ===\n\n";

// 1. PHP is working
echo "1. PHP: OK (v" . PHP_VERSION . ")\n";

// 2. Check extensions
$required = ['pdo_mysql', 'gd', 'zip', 'curl', 'mbstring', 'xml', 'bcmath', 'intl', 'exif'];
echo "\n2. PHP Extensions:\n";
foreach ($required as $ext) {
    echo "   - $ext: " . (extension_loaded($ext) ? 'OK' : 'MISSING') . "\n";
}

// 3. Check critical files
echo "\n3. Critical Files:\n";
$files = [
    '../storage/installed' => 'storage/installed',
    '../vendor/autoload.php' => 'vendor/autoload.php',
    'index.php' => 'public/index.php',
    '../.env' => '.env file',
];
foreach ($files as $path => $label) {
    echo "   - $label: " . (file_exists(__DIR__ . '/' . $path) ? 'EXISTS' : 'MISSING') . "\n";
}

// 4. Environment variables
echo "\n4. Key Env Vars:\n";
$envVars = ['APP_URL', 'APP_ENV', 'APP_DEBUG', 'DB_HOST', 'DB_PORT', 'DB_DATABASE', 'DB_USERNAME', 'FORCE_ROOT_URL', 'FORCE_SCHEMA', 'CMS_ENABLE_INSTALLER', 'ADMIN_DIR'];
foreach ($envVars as $var) {
    $val = getenv($var);
    if ($var === 'DB_PASSWORD' || $var === 'APP_KEY') {
        echo "   - $var: " . ($val ? 'SET (hidden)' : 'NOT SET') . "\n";
    } else {
        echo "   - $var: " . ($val ?: 'NOT SET') . "\n";
    }
}

// 5. Check APP_KEY separately
echo "   - APP_KEY: " . (getenv('APP_KEY') ? 'SET (hidden)' : 'NOT SET') . "\n";

// 6. Database connection test
echo "\n5. Database Connection:\n";
try {
    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $port = getenv('DB_PORT') ?: '3306';
    $db = getenv('DB_DATABASE') ?: '';
    $user = getenv('DB_USERNAME') ?: 'root';
    $pass = getenv('DB_PASSWORD') ?: '';
    
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_TIMEOUT => 5,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    echo "   Status: CONNECTED\n";
    
    // Check tables count
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "   Tables: " . count($tables) . "\n";
    
    // Check if settings table exists and has data
    if (in_array('settings', $tables)) {
        $stmt = $pdo->query("SELECT COUNT(*) FROM settings");
        echo "   Settings rows: " . $stmt->fetchColumn() . "\n";
    } else {
        echo "   Settings table: NOT FOUND\n";
    }
    
    // Check pages
    if (in_array('pages', $tables)) {
        $stmt = $pdo->query("SELECT COUNT(*) FROM pages");
        echo "   Pages count: " . $stmt->fetchColumn() . "\n";
    }
    
    // Check slugs
    if (in_array('slugs', $tables)) {
        $stmt = $pdo->query("SELECT COUNT(*) FROM slugs");
        echo "   Slugs count: " . $stmt->fetchColumn() . "\n";
    }
    
} catch (PDOException $e) {
    echo "   Status: FAILED\n";
    echo "   Error: " . $e->getMessage() . "\n";
}

// 7. Try Laravel bootstrap
echo "\n6. Laravel Bootstrap:\n";
try {
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    echo "   Status: OK\n";
    echo "   Env: " . $app->environment() . "\n";
    echo "   Debug: " . (config('app.debug') ? 'true' : 'false') . "\n";
    echo "   URL: " . config('app.url') . "\n";
    
    // Check registered routes count
    $router = $app->make('router');
    $routes = $router->getRoutes();
    echo "   Registered routes: " . count($routes) . "\n";

    echo "\n=== ROUTES LIST (Top 20) ===\n";
    $count = 0;
    foreach ($routes as $route) {
        if ($count++ > 20) break;
        echo $route->methods()[0] . " | " . $route->uri() . " | " . $route->getName() . "\n";
    }

    echo "\n=== DB CONTENT CHECK ===\n";
    // Check pages table using Laravel DB
    if (\Illuminate\Support\Facades\Schema::hasTable('pages')) {
        $pages = \Illuminate\Support\Facades\DB::table('pages')->select('id', 'name', 'status')->limit(5)->get();
        echo "Pages table found. First 5 rows:\n";
        echo json_encode($pages) . "\n";
    } else {
        echo "CRITICAL: 'pages' table NOT FOUND in Laravel connection.\n";
    }
    
} catch (Throwable $e) {
    echo "   Status: FAILED\n";
    echo "   Error: " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== END HEALTH CHECK ===\n";
