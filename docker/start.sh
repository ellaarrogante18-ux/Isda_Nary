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

# Create PHP-FPM configuration for TCP
echo '[global]
daemonize = no
error_log = /proc/self/fd/2

[www]
listen = 127.0.0.1:9000
listen.allowed_clients = 127.0.0.1
user = www-data
group = www-data

pm = dynamic
pm.max_children = 5
pm.start_servers = 2
pm.min_spare_servers = 1
pm.max_spare_servers = 3' > /usr/local/etc/php-fpm.d/zz-render.conf

# Start supervisord to run php-fpm + nginx
exec /usr/bin/supervisord -n
