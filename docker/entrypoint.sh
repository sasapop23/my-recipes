#!/bin/sh
set -e

cd /var/www/html

# Render.com injects $PORT (usually 10000); Apache must listen on it.
PORT="${PORT:-80}"
export PORT

sed -i "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Bootstrap .env (not copied into image — listed in .dockerignore)
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Render provides public URL; use it when APP_URL is not set manually
if [ -n "$RENDER_EXTERNAL_URL" ]; then
    export APP_URL="$RENDER_EXTERNAL_URL"
fi

# Laravel requires APP_KEY — generate if missing (common cause of HTTP 500)
if [ -z "$APP_KEY" ] && ! grep -q '^APP_KEY=base64:' .env 2>/dev/null; then
    php artisan key:generate --force --no-ansi
fi

# Ensure writable Laravel directories
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# SQLite: create database file if missing
DB_PATH="${DB_DATABASE:-/var/www/html/database/database.sqlite}"
DB_DIR="$(dirname "$DB_PATH")"

mkdir -p "$DB_DIR"
if [ ! -f "$DB_PATH" ]; then
    touch "$DB_PATH"
fi
chown www-data:www-data "$DB_PATH" 2>/dev/null || true
chmod 664 "$DB_PATH" 2>/dev/null || true

# Production caches (skip if APP_KEY still missing)
if [ -n "$APP_KEY" ] || grep -q '^APP_KEY=base64:' .env 2>/dev/null; then
    php artisan config:cache --no-ansi || true
    php artisan route:cache --no-ansi || true
    php artisan view:cache --no-ansi || true
fi

# Apply pending migrations (safe on redeploy with persistent SQLite on Render)
php artisan migrate --force --no-ansi || {
    echo "Warning: migrate exited with an error; continuing startup (tables may already exist)."
}

exec "$@"
