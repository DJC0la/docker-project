#!/bin/bash
set -e

chown -R ${USER_NAME}:${USER_GROUP_NAME} /var/www/html
chmod -R 775 /var/www/html

chmod -R 777 /var/www/html/storage
chmod -R 777 /var/www/html/bootstrap/cache

if [ ! -d "/var/www/html/vendor" ]; then
    echo "Installing composer dependencies..."
    su ${USER_NAME} -s /bin/bash -c "composer install --working-dir=/var/www/html"
fi

exec "$@"