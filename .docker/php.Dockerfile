FROM php:7.3-fpm

LABEL maintainer="Nizar El Berjawi <nizarberjawi12@gmail.com>"

ARG USER
ARG GUID

RUN rm /bin/sh && ln -s /bin/bash /bin/sh

# Install dependencies
RUN apt-get update && \
  apt-get upgrade -y && \
  apt-get install -y --no-install-recommends \
    git \
    zip \
    unzip \
    apt-transport-https \
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

# Add user for laravel application
RUN groupadd -g ${GUID} ${USER}
RUN useradd -u ${GUID} -ms /bin/bash -g ${USER} ${USER}

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
  /var/www/storage

# Give the webserver the rights to read and write to storage and cache
RUN chgrp -R ${USER} /var/www/storage && \
  chmod -R ug+rwx /var/www/storage

USER ${USER}

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
