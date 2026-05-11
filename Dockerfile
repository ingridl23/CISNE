FROM php:8.3-fpm

WORKDIR /app

# Instalar nginx + dependencias PHP
RUN apt-get update && apt-get install -y \
    nginx \
    git unzip curl zip \
    libzip-dev libpng-dev libonig-dev libxml2-dev \
 && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install \
    pdo pdo_mysql mbstring exif pcntl bcmath gd zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader

# Instalar Node.js y compilar assets
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
 && apt-get install -y nodejs \
 && npm install \
 && npm run build \
 && apt-get remove -y nodejs \
 && rm -rf /var/lib/apt/lists/* node_modules

# Permisos correctos para Laravel
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache \
 && chmod -R 775 /app/storage /app/bootstrap/cache

# Config de nginx para Laravel
RUN echo 'server { \n\
    listen 80; \n\
    root /app/public; \n\
    index index.php; \n\
    location / { \n\
        try_files $uri $uri/ /index.php?$query_string; \n\
    } \n\
    location ~ \.php$ { \n\
        fastcgi_pass 127.0.0.1:9000; \n\
        fastcgi_index index.php; \n\
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \n\
        include fastcgi_params; \n\
    } \n\
}' > /etc/nginx/sites-available/default

# Script de arranque: lanza php-fpm y nginx juntos
RUN echo '#!/bin/sh\n\
php-fpm -D\n\
nginx -g "daemon off;"' > /start.sh \
 && chmod +x /start.sh

EXPOSE 80

CMD ["/start.sh"]
