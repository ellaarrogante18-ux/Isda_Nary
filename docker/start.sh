#!/usr/bin/env bash
set -e

# Ensure storage & cache directories exist
mkdir -p storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache || true

# Generate app key if missing (only if APP_KEY not set)
if [ -z "$APP_KEY" ]; then
  php artisan key:generate --force
fi

# Run migrations if an env variable requests it
if [ "$RUN_MIGRATIONS_ON_START" = "true" ]; then
  php artisan migrate --force || true
fi

# Start supervisord to run php-fpm + nginx
exec /usr/bin/supervisord -n
