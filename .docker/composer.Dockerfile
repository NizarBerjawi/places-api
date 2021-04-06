FROM composer:2

RUN addgroup -g 1000 www
RUN adduser -G www -g www -s /bin/sh -D www

WORKDIR /var/www