#!/usr/bin/env bash
set -e

# Ensure storage & cache directories exist
mkdir -p storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache || true

# Generate app key if missing
# Generate application key if missing
if [ ! -f .env ]; then
    cp .env.example .env
fi

php artisan key:generate --force

# Clear and cache config
php artisan config:clear
php artisan config:cache

# Run package discovery
php artisan package:discover

# Run migrations if requested
if [ "$RUN_MIGRATIONS_ON_START" = "true" ]; then
  php artisan migrate --force || true
fi

# Ensure PHP-FPM listens on TCP port 9000
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

# Start supervisord
exec /usr/bin/supervisord -n
