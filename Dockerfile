FROM php:8.0-fpm-alpine

RUN apk update && apk add \
    build-base \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libzip-dev \
    oniguruma-dev \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    nano \
    unzip \
    git \
    curl \
    sudo \
    openssh \
    nodejs \
    npm

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --enable-gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-configure gd
RUN docker-php-ext-install gd

COPY ./config/php/local.ini /usr/local/etc/php/conf.d/local.ini

RUN adduser -u 2000  -S user
RUN mkdir -p /home/user/.ssh
COPY --chown=user:user . /home/user/.ssh

WORKDIR /var/www

RUN addgroup -g 1000 -S www && \
    adduser -u 1000 -S www -G www

USER www

COPY --chown=www:www . /var/www

EXPOSE 9000


