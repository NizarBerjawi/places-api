FROM php:7.3-fpm

LABEL maintainer="Nizar El Berjawi <nizarberjawi12@gmail.com>"

# Set Environment Variables
ENV DEBIAN_FRONTEND noninteractive

# Replace shell with bash so we can source files
RUN rm /bin/sh && ln -s /bin/bash /bin/sh

# Install dependencies
RUN apt-get update && \
  apt-get upgrade -y && \
  apt-get install -y --no-install-recommends \
    git \
    curl \
    zip \
    unzip \
    openssh-client \
    apt-transport-https \
    ca-certificates \
    build-essential \
    libz-dev \
    libzip-dev \
    libpq-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libssl-dev \
    libmcrypt-dev && \
  docker-php-ext-configure gd \
    --with-gd \
    --with-jpeg-dir=/usr/lib \
    --with-png-dir=/usr/lib \
    --with-freetype-dir=/usr/include/freetype2 && \
  docker-php-ext-install gd pdo_mysql exif json zip

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install node js
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -
RUN apt-get install -y nodejs

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Clean up
RUN apt-get -y autoclean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    rm /var/log/lastlog /var/log/faillog

# Copy source files
COPY . /var/www

# Set working directory
WORKDIR /var/www

# Give the webserver ownership of the storage and cache folders
RUN chown -R www:www \
  /var/www/storage \
  /var/www/bootstrap/cache

# Give the webserver the rights to read and write to storage and cache
RUN chgrp -R www /var/www/storage /var/www/bootstrap/cache && \
  chmod -R ug+rwx /var/www/storage /var/www/bootstrap/cache

USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
