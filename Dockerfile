FROM php:8.3-fpm

RUN apt-get update && apt-get install -y git libzip-dev unzip p7zip-full

RUN apt-get update && apt-get install -y git libpq-dev librabbitmq-dev librabbitmq4

RUN docker-php-ext-install pdo_mysql pdo_pgsql

RUN pecl install amqp && docker-php-ext-enable amqp

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
