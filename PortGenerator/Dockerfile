FROM php:8.4-fpm

# Install system dependencies and PostgreSQL driver
RUN apt-get update && apt-get install -y \
    nginx \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy application files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions for storage & cache
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Copy Nginx config
COPY nginx.conf /etc/nginx/sites-available/default

EXPOSE 80

CMD php artisan config:cache && php artisan route:cache && php artisan view:cache && service nginx start && php-fpm