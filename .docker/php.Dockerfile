FROM php:7.3-fpm-alpine3.13

LABEL maintainer="Nizar El Berjawi <nizarberjawi12@gmail.com>"

ARG USER
ARG GUID

WORKDIR /var/www/html/

RUN echo "UTC" > /etc/timezone
RUN apk add --no-cache \
    git \
    zip \
    bash \
    unzip \
    libzip-dev && \
  docker-php-ext-install \
    pdo \
    pdo_mysql \
    zip

RUN sed -i 's/bin\/ash/bin\/bash/g' /etc/passwd

# Add a user for the application
RUN addgroup -g ${GUID} ${USER}
RUN adduser -G ${USER} -g ${USER} -s /bin/sh -D ${USER}

RUN chown -R ${USER}:${USER} .

USER ${USER}

CMD ["php-fpm"]
