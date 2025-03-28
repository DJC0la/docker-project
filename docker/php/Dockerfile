FROM php:8.3-fpm

# Установка расширений PHP и инструментов
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Установка расширений PHP
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

USER www-data

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html