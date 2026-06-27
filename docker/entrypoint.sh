#!/bin/sh
set -e

cd /var/www/html

# Render.com injects $PORT (usually 10000); Apache must listen on it.
PORT="${PORT:-80}"
export PORT

sed -i "s/^Listen .*/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

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

# Production caches (safe to skip if APP_KEY is not set yet)
if [ -n "$APP_KEY" ]; then
    php artisan config:cache --no-ansi || true
    php artisan route:cache --no-ansi || true
    php artisan view:cache --no-ansi || true
fi

# Apply pending migrations (safe on redeploy with persistent SQLite on Render)
php artisan migrate --force --no-ansi || {
    echo "Warning: migrate exited with an error; continuing startup (tables may already exist)."
}

exec "$@"
