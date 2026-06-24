# syntax=docker/dockerfile:1

# ---------------------------------------------------------------------------
# Stage 1: build frontend assets (Vite + Tailwind)
# ---------------------------------------------------------------------------
FROM node:22-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY vite.config.js ./
COPY resources ./resources
RUN npm run build

# ---------------------------------------------------------------------------
# Stage 2: PHP 8.4 + Apache runtime for Render.com
# ---------------------------------------------------------------------------
FROM php:8.4-apache AS runtime

LABEL org.opencontainers.image.title="my-recipes"
LABEL org.opencontainers.image.description="Laravel recipe site for Render.com"

# System deps + PHP extensions (SQLite, Laravel essentials)
RUN apt-get update && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libzip-dev \
        libsqlite3-dev \
    && docker-php-ext-install \
        pdo_sqlite \
        sqlite3 \
        zip \
        opcache \
    && a2enmod rewrite headers \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Install PHP dependencies first (better layer caching)
COPY composer.json composer.lock ./
RUN composer install \
        --no-dev \
        --no-interaction \
        --no-scripts \
        --prefer-dist \
        --optimize-autoloader

# Application code
COPY . .
COPY --from=frontend /app/public/build ./public/build

# Apache vhost for Laravel (DocumentRoot = public/)
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Startup: SQLite file, migrations, Render PORT, then Apache
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh \
    && composer dump-autoload --optimize \
    && php artisan package:discover --ansi \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["apache2-foreground"]
