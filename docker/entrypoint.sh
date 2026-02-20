#!/bin/sh
set -e

echo "=== Starting deployment ==="

cd /var/www/html

# Create storage symlink
php artisan storage:link --force 2>/dev/null || true

# Cache configuration for performance
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Run migrations
echo "=== Running migrations ==="
php artisan migrate --force || true

# Publish CMS assets
php artisan cms:publish:assets 2>/dev/null || true

# Fix permissions after caching
chown -R www-data:www-data storage bootstrap/cache public/storage 2>/dev/null || true

echo "=== Starting services ==="

# Start Supervisor (manages PHP-FPM + Nginx)
exec /usr/bin/supervisord -c /etc/supervisord.conf
