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

# Create storage symlink
php artisan storage:link --force 2>/dev/null || true

# Clear any old caches first
php artisan config:clear 2>/dev/null || true
php artisan route:clear 2>/dev/null || true
php artisan view:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true

# Cache config (but NOT routes - Botble uses closure routes)
php artisan config:cache 2>&1 || echo "WARNING: config:cache failed"
php artisan view:cache 2>&1 || echo "WARNING: view:cache failed"

# Do NOT cache routes - Botble CMS uses closure-based routes
# php artisan route:cache

# Run migrations
echo "=== Running migrations ==="
php artisan migrate --force 2>&1 || echo "WARNING: migration failed"

# Publish CMS assets
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

echo "=== Starting services ==="

# Start Supervisor (manages PHP-FPM + Nginx)
exec /usr/bin/supervisord -c /etc/supervisord.conf
