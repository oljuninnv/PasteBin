FROM php:8.2-fpm

COPY ./ci-cd/build-configs/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./ci-cd/build-configs/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY ci-cd/build-configs/php.ini "$PHP_INI_DIR/php.ini"
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-install fileinfo
RUN apt-get update && apt-get install -y zlib1g-dev && apt-get install -y libzip-dev
RUN docker-php-ext-install zip

WORKDIR /src

COPY --chown=82:82 . .