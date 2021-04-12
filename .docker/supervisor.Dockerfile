FROM php:7.3-alpine

LABEL maintainer="Nizar El Berjawi <nizarberjawi12@gmail.com>"

RUN apk --update add supervisor

RUN addgroup -g 1000 www
RUN adduser -G www -g www -s /bin/sh -D www

RUN rm /var/cache/apk/* \
    && mkdir -p /var/www

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisord.conf"]

WORKDIR /etc/supervisor/conf.d/
