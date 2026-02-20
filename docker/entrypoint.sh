#!/bin/sh
set -e

echo "=== Starting deployment ==="

cd /var/www/html

# CRITICAL: Create 'installed' marker file for Botble CMS
# This file is in .gitignore but Botble CMS needs it to function
if [ ! -f storage/installed ]; then
    echo "Creating storage/installed marker..."
    echo "$(date)" > storage/installed
fi

# Remove any stale 'installing' file
rm -f storage/installing

# Debug info - verify Render env vars are loaded
echo "=== Debug Info ==="
echo "APP_URL: ${APP_URL:-NOT SET}"
echo "DB_HOST: ${DB_HOST:-NOT SET}"
echo "DB_PORT: ${DB_PORT:-NOT SET}"
echo "DB_DATABASE: ${DB_DATABASE:-NOT SET}"
echo "DB_USERNAME: ${DB_USERNAME:-NOT SET}"
echo "DB_PASSWORD set: $(test -n "$DB_PASSWORD" && echo 'YES' || echo 'NO')"
echo "APP_KEY set: $(test -n "$APP_KEY" && echo 'YES' || echo 'NO')"
echo "FORCE_ROOT_URL: ${FORCE_ROOT_URL:-NOT SET}"
echo "FORCE_SCHEMA: ${FORCE_SCHEMA:-NOT SET}"
echo "PHP version: $(php -v | head -1)"
php artisan --version
echo "storage/installed exists: $(test -f storage/installed && echo 'YES' || echo 'NO')"

echo "=== File System Check ==="
echo "Current dir: $(pwd)"
echo "public/ directory:"
ls -la public/ | head -20
echo "public/index.php exists: $(test -f public/index.php && echo 'YES' || echo 'NO')"
echo "public/test.html exists: $(test -f public/test.html && echo 'YES' || echo 'NO')"
echo "public/healthcheck.php exists: $(test -f public/healthcheck.php && echo 'YES' || echo 'NO')"

echo "=== PHP-FPM Config ==="
echo "PHP-FPM configs:"
ls -la /usr/local/etc/php-fpm.d/
echo "zz-docker.conf contents:"
cat /usr/local/etc/php-fpm.d/zz-docker.conf

echo "=== Nginx Config ==="
nginx -t 2>&1
echo "Nginx root check:"
ls -la /var/www/html/public/index.php 2>&1 || echo "index.php NOT FOUND"

echo "=== DB Connection Test ==="
php -r "
try {
    \$pdo = new PDO(
        'mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_DATABASE'),
        getenv('DB_USERNAME'),
        getenv('DB_PASSWORD'),
        [PDO::ATTR_TIMEOUT => 5]
    );
    echo 'DB: CONNECTED' . PHP_EOL;
    \$count = \$pdo->query('SHOW TABLES')->rowCount();
    echo 'Tables: ' . \$count . PHP_EOL;
} catch (Exception \$e) {
    echo 'DB: FAILED - ' . \$e->getMessage() . PHP_EOL;
}
" 2>&1

echo "=== End Debug Info ==="

# Create storage symlink
php artisan storage:link --force 2>/dev/null || true

# Clear ALL caches — start fresh with Render's env vars
echo "=== Clearing caches ==="
php artisan config:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true

# DO NOT cache config — let Laravel read env vars at runtime
# config:cache can bake wrong values if env isn't fully loaded
# php artisan config:cache

# DO NOT cache routes — Botble CMS uses closure-based routes
# php artisan route:cache

# Cache views only (safe, no env dependency)
php artisan view:cache 2>&1 || echo "WARNING: view:cache failed"

# Run migrations
echo "=== Running migrations ==="
php artisan migrate --force 2>&1 || echo "WARNING: migration failed"

# Create missing plugin public directories to prevent cms:publish:assets errors
mkdir -p platform/plugins/receptionist-portal/public 2>/dev/null || true

# Publish CMS assets
echo "=== Publishing assets ==="
php artisan cms:publish:assets 2>&1 || echo "WARNING: cms:publish:assets failed"

# Set media driver to s3 in database if AWS is configured
if [ -n "$AWS_ACCESS_KEY_ID" ] && [ -n "$AWS_BUCKET" ]; then
    echo "=== Setting media driver to S3 ==="
    php artisan tinker --execute="
        \Botble\Setting\Facades\Setting::set('media_driver', 's3');
        \Botble\Setting\Facades\Setting::save();
        echo 'Media driver set to S3';
    " 2>&1 || echo "WARNING: Could not set media driver to S3"
fi

# Fix permissions
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

echo "=== Starting Supervisor (PHP-FPM + Nginx) ==="

# Start Supervisor (manages PHP-FPM + Nginx)
exec /usr/bin/supervisord -c /etc/supervisord.conf
