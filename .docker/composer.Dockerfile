FROM composer:2

ARG USER
ARG GUID

RUN addgroup -g ${GUID} ${USER}
RUN adduser -G ${USER} -g ${USER} -s /bin/sh -D ${USER}

WORKDIR /var/www

USER ${USER}