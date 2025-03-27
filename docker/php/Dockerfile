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

USER root

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Установка прав доступа
RUN chown -R www-data:www-data /var/www
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

RUN mkdir -p /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/storage \
    && chmod -R 755 /var/www/html/storage

# Переключение на пользователя www-data
USER www-data