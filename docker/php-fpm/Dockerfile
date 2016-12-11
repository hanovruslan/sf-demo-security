FROM php:7.0-fpm

RUN docker-php-ext-install pdo_mysql \
    && docker-php-ext-enable pdo_mysql

ARG APP_PATH=/usr/share/sf-security-demo

WORKDIR ${APP_PATH}

COPY ./src ./
