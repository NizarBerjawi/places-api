FROM php:7.3-alpine3.13

LABEL maintainer="Nizar El Berjawi <nizarberjawi12@gmail.com>"

ARG USER
ARG GUID

RUN apk --update add --no-cache \
    supervisor

RUN sed -i 's/bin\/ash/bin\/bash/g' /etc/passwd

RUN addgroup -g ${GUID} ${USER}
RUN adduser -G ${USER} -g ${USER} -s /bin/sh -D ${USER}

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisord.conf"]

WORKDIR /etc/supervisor/conf.d/
