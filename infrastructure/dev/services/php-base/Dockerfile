FROM alpine:3.6

RUN apk --update upgrade && apk add bash && rm -rf /var/cache/apk/*

# Php
RUN apk --update add \
    php7 \
    php7-apcu \
    php7-calendar \
    php7-ctype \
    php7-curl \
    php7-dom \
    php7-iconv \
    php7-intl \
    php7-json \
    php7-mbstring \
    php7-opcache \
    php7-openssl \
    php7-pdo \
    php7-pdo_mysql \
    php7-pcntl \
    php7-posix \
    php7-session \
    php7-simplexml \
    php7-sockets \
    php7-tokenizer \
    php7-xml \
    php7-zip \
    pcre \
    && \
    rm -rf /var/cache/apk/*


# Install fake user chubbycoon
ARG CHUBBYCOON_UID=1000
RUN addgroup -g 1000 chubbycoon && \
    adduser -S -u $CHUBBYCOON_UID -h /home/chubbycoon -s /bin/bash chubbycoon chubbycoon

# Configuration
COPY app.ini /etc/php7/conf.d/app.ini
