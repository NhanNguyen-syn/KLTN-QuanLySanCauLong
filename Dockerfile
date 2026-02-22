# ================================================================
# Stage 1: Build frontend assets
# ================================================================
FROM node:20-alpine AS node-builder

WORKDIR /app

# Copy entire project
COPY . .

# Ensure output directories exist
RUN mkdir -p public/themes/quanlysancaulong \
    && mkdir -p platform/themes/quanlysancaulong/public/js \
    && mkdir -p platform/themes/quanlysancaulong/public/css

# Install dependencies
RUN npm install --no-audit --no-fund 2>/dev/null; exit 0

# Build theme assets with Laravel Mix
# webpack.mix.js reads theme from npm_config_theme env var, NOT --theme flag
RUN npm_config_theme=quanlysancaulong npx mix --production; exit 0

# Ensure mix-manifest.json exists (create empty one if build failed)
RUN if [ ! -f public/mix-manifest.json ]; then echo '{}' > public/mix-manifest.json; fi

# ================================================================
# Stage 2: Install PHP dependencies
# ================================================================
FROM composer:2 AS composer-builder

WORKDIR /app

COPY composer.json composer.lock ./
COPY platform/ ./platform/

RUN composer install \
    --no-dev \
    --no-interaction \
    --no-scripts \
    --prefer-dist \
    --optimize-autoloader \
    --ignore-platform-reqs

# ================================================================
# Stage 3: Production image
# ================================================================
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    ca-certificates \
    openssl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    libwebp-dev \
    icu-dev \
    oniguruma-dev \
    curl-dev \
    libxml2-dev \
    dos2unix \
    && docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp \
    && docker-php-ext-install -j$(nproc) \
    gd \
    pdo_mysql \
    zip \
    exif \
    bcmath \
    intl \
    mbstring \
    curl \
    xml \
    opcache \
    && rm -rf /var/cache/apk/*

# Configure PHP for production
RUN { \
    echo 'opcache.memory_consumption=128'; \
    echo 'opcache.interned_strings_buffer=8'; \
    echo 'opcache.max_accelerated_files=10000'; \
    echo 'opcache.revalidate_freq=0'; \
    echo 'opcache.validate_timestamps=0'; \
    echo 'opcache.enable_cli=1'; \
    } > /usr/local/etc/php/conf.d/opcache.ini \
    && { \
    echo 'upload_max_filesize=50M'; \
    echo 'post_max_size=50M'; \
    echo 'memory_limit=256M'; \
    echo 'max_execution_time=120'; \
    } > /usr/local/etc/php/conf.d/custom.ini

# Nginx configuration - replace main config entirely
RUN mkdir -p /run/nginx
COPY docker/nginx.conf /etc/nginx/nginx.conf

# PHP-FPM configuration - explicit listen on 127.0.0.1:9000
COPY docker/php-fpm.conf /usr/local/etc/php-fpm.d/zz-docker.conf

# Supervisor configuration
COPY docker/supervisord.conf /etc/supervisord.conf

WORKDIR /var/www/html

# Copy application code
COPY --chown=www-data:www-data . .

# Copy Composer dependencies
COPY --from=composer-builder /app/vendor ./vendor

# Copy built frontend assets from node-builder
COPY --from=node-builder /app/public/themes ./public/themes
COPY --from=node-builder /app/public/mix-manifest.json ./public/mix-manifest.json
COPY --from=node-builder /app/platform/themes/quanlysancaulong/public ./platform/themes/quanlysancaulong/public

# Create required directories and the critical 'installed' marker
RUN mkdir -p storage/framework/{sessions,views,cache/data} \
    && mkdir -p storage/logs \
    && mkdir -p storage/app/public \
    && mkdir -p bootstrap/cache \
    && mkdir -p public/storage \
    && echo "$(date)" > storage/installed \
    && rm -f storage/installing

# Fix CRLF line endings on shell scripts (created on Windows)
RUN dos2unix /var/www/html/docker/entrypoint.sh 2>/dev/null || \
    sed -i 's/\r$//' /var/www/html/docker/entrypoint.sh

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache public/storage \
    && chmod -R 775 storage bootstrap/cache

# Copy entrypoint and fix line endings
COPY docker/entrypoint.sh /entrypoint.sh
RUN dos2unix /entrypoint.sh 2>/dev/null || sed -i 's/\r$//' /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Verify critical files exist
RUN echo "=== Verifying deployment ===" \
    && ls -la public/index.php \
    && ls -la storage/installed \
    && php -v \
    && echo "=== Verification complete ==="

EXPOSE 10000

ENTRYPOINT ["/entrypoint.sh"]
