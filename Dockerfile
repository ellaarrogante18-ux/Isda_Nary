# Use official PHP with FPM
FROM php:8.2-fpm

# System deps
RUN apt-get update && apt-get install -y \
    git unzip curl libonig-dev libzip-dev zip libpng-dev libjpeg-dev libxml2-dev \
    nginx supervisor procps \
    libfreetype6-dev libjpeg62-turbo-dev \
 && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# Install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working dir
WORKDIR /var/www

# Copy app
COPY . /var/www

# Set composer configuration
ENV COMPOSER_MEMORY_LIMIT=-1
ENV COMPOSER_ALLOW_SUPERUSER=1

# Debug composer install with verbose output
RUN rm -f composer.lock
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress -vvv

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Copy nginx config
RUN rm -f /etc/nginx/sites-enabled/default
COPY docker/nginx.conf /etc/nginx/sites-available/default
RUN ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/

# Supervisor to run php-fpm and nginx
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 10000

# Start script
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

CMD [ "/start.sh" ]
