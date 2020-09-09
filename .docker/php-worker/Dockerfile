ARG PHP_VERSION=7.3
FROM php:7.3-alpine

LABEL maintainer="Nizar El Berjawi <nizarberjawi12@gmail.com>"

RUN apk --update add \
  wget \
  zip \
  unzip \
  build-base \
  libmemcached-dev \
  libmcrypt-dev \
  libxml2-dev \
  pcre-dev \
  zlib-dev \
  libzip-dev \
  autoconf \
  cyrus-sasl-dev \
  libgsasl-dev \
  supervisor

RUN docker-php-ext-install mysqli mbstring pdo pdo_mysql tokenizer xml pcntl zip
RUN pecl channel-update pecl.php.net && pecl install memcached mcrypt-1.0.1 && docker-php-ext-enable memcached

RUN addgroup -g 1000 laravel && \
    adduser -D -G laravel -u 1000 laravel

RUN rm /var/cache/apk/* \
    && mkdir -p /var/www

COPY supervisord.conf /etc/supervisord.conf

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisord.conf"]

WORKDIR /etc/supervisor/conf.d/
