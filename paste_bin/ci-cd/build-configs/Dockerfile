FROM php:8.2-fpm

   # Копирование конфигурационных файлов PHP
   COPY ./ci-cd/build-configs/www.conf /usr/local/etc/php-fpm.d/www.conf
   COPY ./ci-cd/build-configs/php-fpm.conf /usr/local/etc/php-fpm.conf
   COPY ci-cd/build-configs/php.ini "$PHP_INI_DIR/php.ini"

   # Установка Composer
   COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

   # Установка необходимых пакетов и расширений PHP
   RUN apt-get update && apt-get install -y \
       build-essential\ 
       libpng-dev \
       libjpeg62-turbo-dev \
       libfreetype6-dev \
       locales \
       zip \
       jpegoptim optipng pngquant gifsicle\ 
       vim \
       unzip \
       git \
       curl \
       libpq-dev \
       libonig-dev \
       libzip-dev \
       && docker-php-ext-configure gd --with-freetype --with-jpeg \
       && docker-php-ext-install gd \
       && docker-php-ext-install pdo_mysql mbstring zip exif pcntl fileinfo

   RUN curl -sL https://deb.nodesource.com/setup_16.x | bash - \
       && apt-get install -y nodejs \
       && node -v \
       && npm -v \
       && apt-get clean && rm -rf /var/lib/apt/lists/*

   WORKDIR /src

   COPY --chown=82:82 . .

   RUN npm install