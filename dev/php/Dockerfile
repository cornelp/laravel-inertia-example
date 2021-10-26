FROM php:8.0-fpm

USER root

RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libfreetype6-dev \
    libzip-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    libxrender-dev \
    libicu-dev \
    libfontconfig1 \
    libxext-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install exif

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

ENV XDG_CONFIG_HOME "/var/www/storage/framework/cache" 

USER 1000:1000

WORKDIR /var/www
