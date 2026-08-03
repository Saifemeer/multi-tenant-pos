FROM php:8.2-fpm

# System dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip nginx

# PHP Extensions install
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Composer install
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

# Storage permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

EXPOSE 80

# Updated CMD line to ensure port 80 always starts
CMD php artisan serve --host=0.0.0.0 --port=80