# ================================================================
# Stage 1: Build frontend assets
# ================================================================
FROM node:20-alpine AS node-builder

WORKDIR /app

# Copy entire project (needed for workspace resolution + mix build)
COPY . .

# Install dependencies
RUN npm install --no-audit --no-fund 2>/dev/null; exit 0

# Build theme assets with Laravel Mix
RUN npx mix --production --theme=quanlysancaulong; exit 0

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
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    libwebp-dev \
    icu-dev \
    oniguruma-dev \
    curl-dev \
    libxml2-dev \
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

# Nginx configuration
RUN mkdir -p /run/nginx
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Supervisor configuration
COPY docker/supervisord.conf /etc/supervisord.conf

WORKDIR /var/www/html

# Copy application code
COPY --chown=www-data:www-data . .

# Copy Composer dependencies
COPY --from=composer-builder /app/vendor ./vendor

# Copy built frontend assets from node builder
# Use a shell to handle potentially missing files gracefully
RUN --mount=from=node-builder,source=/app/public/themes,target=/tmp/node-themes \
    cp -r /tmp/node-themes/* public/themes/ 2>/dev/null || true

RUN --mount=from=node-builder,source=/app/public,target=/tmp/node-public \
    cp -f /tmp/node-public/mix-manifest.json public/mix-manifest.json 2>/dev/null || true

RUN --mount=from=node-builder,source=/app/platform/themes/quanlysancaulong/public,target=/tmp/theme-public \
    cp -r /tmp/theme-public/* platform/themes/quanlysancaulong/public/ 2>/dev/null || true

# Create required directories
RUN mkdir -p storage/framework/{sessions,views,cache/data} \
    && mkdir -p storage/logs \
    && mkdir -p storage/app/public \
    && mkdir -p bootstrap/cache \
    && mkdir -p public/storage

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache public/storage \
    && chmod -R 775 storage bootstrap/cache

# Copy entrypoint
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 10000

ENTRYPOINT ["/entrypoint.sh"]
