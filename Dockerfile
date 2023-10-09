FROM php:8.2-cli

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apt-get update && apt-get install -y \
    zip \
    libzip-dev
RUN docker-php-ext-install zip

COPY ./app /usr/src/feeCalculator

WORKDIR /usr/src/feeCalculator
