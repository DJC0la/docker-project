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

RUN apt-get update && apt-get install -y \
    git curl libzip-dev libpng-dev \
    libonig-dev libxml2-dev zip unzip

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY docker-entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

WORKDIR /var/www/html

ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]