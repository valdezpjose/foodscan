FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
      libzip-dev libxml2-dev libmagickwand-dev libonig-dev \
      libcurl4-openssl-dev wget \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install pdo_mysql mbstring zip exif curl xml bcmath \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html
