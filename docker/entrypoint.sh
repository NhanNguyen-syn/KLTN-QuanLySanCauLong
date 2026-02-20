#!/bin/sh
set -e

echo "=== Starting deployment ==="

cd /var/www/html

# Create storage symlink
php artisan storage:link --force 2>/dev/null || true

# Clear any old caches first
php artisan config:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true

# Cache config (but NOT routes - Botble uses closure routes)
php artisan config:cache || echo "WARNING: config:cache failed"
php artisan view:cache || echo "WARNING: view:cache failed"

# Do NOT cache routes - Botble CMS uses closure-based routes
# php artisan route:cache

# Run migrations
echo "=== Running migrations ==="
php artisan migrate --force 2>&1 || echo "WARNING: migration failed"

# Publish CMS assets
php artisan cms:publish:assets 2>/dev/null || true

# Fix permissions after caching
chown -R www-data:www-data storage bootstrap/cache public/storage 2>/dev/null || true
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

echo "=== Starting services ==="

# Start Supervisor (manages PHP-FPM + Nginx)
exec /usr/bin/supervisord -c /etc/supervisord.conf
