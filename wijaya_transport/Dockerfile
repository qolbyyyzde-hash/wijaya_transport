FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git libonig-dev libpng-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mysqli zip gd mbstring xml

RUN a2enmod rewrite

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]
