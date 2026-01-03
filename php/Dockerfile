FROM php:8.2-fpm-alpine

# Installer les extensions nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Configuration PHP
RUN echo 'upload_max_filesize = 100M' > /usr/local/etc/php/conf.d/uploads.ini && \
    echo 'post_max_size = 100M' >> /usr/local/etc/php/conf.d/uploads.ini && \
    echo 'memory_limit = 256M' >> /usr/local/etc/php/conf.d/uploads.ini

WORKDIR /var/www/html

EXPOSE 9000

