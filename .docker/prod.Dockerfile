#################################
## Install PHP vendor packages ##
#################################
FROM composer:2 as composer
WORKDIR /app

COPY composer.* /app/
Run composer install \
  --no-dev \
  --no-scripts \
  --no-suggest \
  --no-interaction \
  --prefer-dist \
  --optimize-autoloader

COPY . /app
RUN composer dump-autoload \
  --no-dev \
  --optimize \
  --classmap-authoritative

############################
## Generate Open API Spec ##
############################

FROM php:7.3-alpine3.13 as documentation

WORKDIR /app

COPY . . 
COPY --from=composer /app/vendor ./vendor

RUN php artisan docs:generate

############################
## Build front-end assets ##
############################
FROM node:14-alpine3.13 as node
WORKDIR /app

COPY ./package.json ./package-lock.json /app/
COPY ./resources/src /app/resources/src
COPY ./webpack.config.js /app/webpack.config.js
COPY --from=documentation /app/openApi.json /app/openApi.json

RUN npm ci --verbose
RUN npm run build

#################################
## Build application container ##
#################################

FROM php:7.3-fpm-alpine3.13

LABEL maintainer="Nizar El Berjawi <nizarberjawi12@gmail.com>"

WORKDIR /var/www/html/

RUN echo "UTC" > /etc/timezone
RUN apk add --no-cache \
    zip \
    unzip \
    libzip-dev && \
  docker-php-ext-install \
    pdo \
    pdo_mysql \
    zip

COPY --chown=www-data:www-data . .

RUN chmod -R ug+rwx ./storage
RUN find . -type f -exec chmod 644 {} \;
RUN find . -type d -exec chmod 755 {} \;

COPY --from=node --chown=www-data:www-data /app/public/dist ./public/dist
COPY --from=composer --chown=www-data:www-data /app/vendor ./vendor

COPY .docker/php /etc/php7

USER www-data

EXPOSE 9000
CMD ["php-fpm"]
