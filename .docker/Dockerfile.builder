##########################
## Install PHP packages ##
##########################
FROM composer:2 as composer
WORKDIR /app

COPY composer.* /app/
RUN composer install \
  --no-dev \
  --no-scripts \
  --no-suggest \
  --no-interaction \
  --prefer-dist \
  --optimize-autoloader

COPY . .
RUN composer dump-autoload \
  --no-dev \
  --optimize \
  --classmap-authoritative

###########################
## Generate OpenAPI Spec ##
###########################
FROM php:7.3-fpm-alpine3.13 as documentation

# Because .env file variables are not available during
# build, we have to explicitly set APP_URL environment
# variable to be used when generating the spec
ARG APP_URL ${APP_URL}
ENV APP_URL ${APP_URL}

WORKDIR /app

COPY . . 
COPY --from=composer /app/vendor ./vendor

RUN php artisan docs:generate

#############################
## Bundle front-end assets ##
#############################
FROM node:14-alpine3.13 as builder
WORKDIR /app

COPY ./package.json ./package-lock.json /app/
COPY ./resources/src /app/resources/src
COPY ./webpack.config.js /app/webpack.config.js

COPY --from=composer /app/vendor ./vendor
COPY --from=documentation /app/openApi.json ./openApi.json

RUN npm ci --verbose
RUN npm run build