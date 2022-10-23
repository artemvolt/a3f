FROM php:8.0-fpm
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apt-get update && apt-get install -y nano vim wget git unzip zlib1g-dev libpng-dev libzip-dev libpq-dev libicu-dev iputils-ping

RUN docker-php-ext-install bcmath zip gd intl
RUN rm -r /var/www/html
WORKDIR /var/www