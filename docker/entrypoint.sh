#!/bin/sh
set -e

echo "=== Starting deployment ==="
cd /var/www/html

# ---------- FORCE important env defaults ----------
# Render / proxy: trust all proxies to avoid HTTPS redirect loops
export TRUSTED_PROXIES="${TRUSTED_PROXIES:-*}"

# If APP_URL is not set, try to use Render external url (if exists)
if [ -z "${APP_URL}" ] && [ -n "${RENDER_EXTERNAL_URL}" ]; then
  export APP_URL="${RENDER_EXTERNAL_URL}"
fi

echo "=== Debug Info ==="
echo "APP_URL: ${APP_URL:-NOT SET}"
echo "TRUSTED_PROXIES: ${TRUSTED_PROXIES:-NOT SET}"
echo "DB_HOST: ${DB_HOST:-NOT SET}"
echo "DB_PORT: ${DB_PORT:-NOT SET}"
echo "DB_DATABASE: ${DB_DATABASE:-NOT SET}"
echo "DB_USERNAME: ${DB_USERNAME:-NOT SET}"
echo "DB_PASSWORD set: $(test -n "$DB_PASSWORD" && echo 'YES' || echo 'NO')"
echo "APP_KEY set: $(test -n "$APP_KEY" && echo 'YES' || echo 'NO')"
echo "PHP version: $(php -v | head -1)"
php artisan --version || true

# ---------- Botble installed marker ----------
if [ ! -f storage/installed ]; then
  echo "Creating storage/installed marker..."
  echo "$(date)" > storage/installed
fi
rm -f storage/installing

# ---------- Force-write Nginx & PHP-FPM configs to correct locations ----------
echo "=== Applying runtime configs ==="
# Nginx
if [ -f /var/www/html/nginx.conf ]; then
  cp /var/www/html/nginx.conf /etc/nginx/nginx.conf
fi

# PHP-FPM pool (must be www.conf in php-fpm.d)
if [ -f /var/www/html/php-fpm.conf ]; then
  cp /var/www/html/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
fi

echo "=== Validate Nginx config ==="
nginx -t 2>&1 || (echo "Nginx config invalid" && exit 1)

echo "=== Validate PHP-FPM config ==="
php-fpm -tt 2>&1 || (echo "PHP-FPM config invalid" && exit 1)

echo "=== File System Check ==="
echo "public/index.php exists: $(test -f public/index.php && echo 'YES' || echo 'NO')"

# ---------- DB Connection Test (non-fatal) ----------
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

# ---------- Storage link & caches ----------
php artisan storage:link --force 2>/dev/null || true

echo "=== Clearing caches ==="
php artisan optimize:clear 2>/dev/null || true

# ---------- Migrations & assets (non-fatal to avoid crash loop) ----------
echo "=== Running migrations ==="
php artisan migrate --force 2>&1 || echo "WARNING: migration failed"

# Prevent cms:publish:assets fail because missing plugin folder
mkdir -p platform/plugins/receptionist-portal/public 2>/dev/null || true

echo "=== Publishing assets ==="
php artisan cms:publish:assets 2>&1 || echo "WARNING: cms:publish:assets failed"

# Optional: set media driver to s3 in database if AWS configured
if [ -n "$AWS_ACCESS_KEY_ID" ] && [ -n "$AWS_BUCKET" ]; then
  echo "=== Setting media driver to S3 ==="
  php artisan tinker --execute="
    \Botble\Setting\Facades\Setting::set('media_driver', 's3');
    \Botble\Setting\Facades\Setting::save();
    echo 'Media driver set to S3';
  " 2>&1 || echo "WARNING: Could not set media driver to S3"
fi

chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

echo "=== Starting Supervisor (PHP-FPM + Nginx) ==="
exec /usr/bin/supervisord -c /etc/supervisord.conf