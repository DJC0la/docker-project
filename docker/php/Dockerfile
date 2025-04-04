FROM php:8.3-fpm

ARG TIME_ZONE
ARG USER_NAME
ARG USER_ID
ARG USER_GROUP_NAME
ARG USER_GROUP_ID

RUN ln -snf /usr/share/zoneinfo/${TIME_ZONE} /etc/localtime \
    && echo ${TIME_ZONE} > /etc/timezone 
RUN addgroup --system --gid ${USER_GROUP_ID} ${USER_GROUP_NAME} \
    && adduser --system --uid ${USER_ID} --ingroup ${USER_GROUP_NAME} ${USER_NAME}

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

RUN chown -R www-data:www-data /var/www/html/
RUN chmod -R 755 /var/www/html/

USER www-data

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html