FROM ${CONTAINER_PROXY}composer:2.6 AS composer

FROM php:8.1-apache

RUN apt-get update && \
    apt-get install -y \
            libzip-dev \
            zip \
            vim \
    && docker-php-ext-install mysqli pdo pdo_mysql zip

COPY --from=composer --link /usr/bin/composer /usr/local/bin/composer

RUN a2enmod rewrite
