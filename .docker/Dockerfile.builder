##########################
## Install PHP packages ##
##########################
FROM php:8.1.11-cli-alpine3.16 as vendor

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

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
FROM php:8.1.11-cli-alpine3.16 as documentation

# Because .env file variables are not available during
# build, we have to explicitly set APP_URL environment
# variable to be used when generating the spec
ARG APP_URL ${APP_URL}
ENV APP_URL ${APP_URL}

WORKDIR /app

COPY . . 
COPY --from=vendor /app/vendor ./vendor

RUN php artisan docs:generate

#############################
## Bundle front-end assets ##
#############################
FROM node:16.17.1-alpine3.16 as node

WORKDIR /app

COPY ./package.json ./package-lock.json /app/
COPY ./resources/src /app/resources/src
COPY ./webpack.config.js /app/webpack.config.js

COPY --from=documentation /app/public/openApi.json ./public/openApi.json

RUN npm ci --verbose
RUN npm run build

#########################
## Final builder image ##
#########################
FROM php:8.1.11-cli-alpine3.16 as builder

WORKDIR /app

COPY . .

COPY --from=documentation /app/public/openApi.json ./public/openApi.json
COPY --from=vendor /app/vendor ./vendor
COPY --from=node /app/public/dist ./public/dist