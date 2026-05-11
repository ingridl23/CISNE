FROM php:8.3-fpm

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git unzip curl zip \
    libzip-dev libpng-dev libonig-dev libxml2-dev

RUN docker-php-ext-install \
    pdo pdo_mysql mbstring exif pcntl bcmath gd zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader

# Limpieza de Laravel (seguro para build)
RUN php artisan config:clear || true
RUN php artisan cache:clear || true

CMD ["php-fpm"]
