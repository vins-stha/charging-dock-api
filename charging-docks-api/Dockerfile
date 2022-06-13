FROM php:7.3-fpm-alpine

# Install system dependencies

RUN docker-php-ext-install pdo pdo_mysql
RUN curl -sS https://getcomposer.org/installer​ | php -- \
     --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/laravel

COPY . .
RUN composer install
RUN composer require doctrine/dbal


