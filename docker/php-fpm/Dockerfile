FROM php:fpm-alpine

ENV PHP_TIMEZONE=UTC \
    PHP_MEMORY_LIMIT="256M" \
    PHP_OPCACHE_ENABLE="0" \
    PHP_OPCACHE_ENABLE_CLI="0" \
    PHP_FPM_SLOWLOG_TIMEOUT=5s \
    COMPOSER_HOME=/home/www-data/.composer

RUN apk add --no-cache --update \
    git \
    tzdata \
    postgresql-dev \
    bash \
    bash-completion \
    rabbitmq-c-dev

RUN apk add --no-cache --virtual .phpize-deps $PHPIZE_DEPS \
    && docker-php-ext-configure intl --enable-intl \
    && docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-install \
        intl \
        opcache \
        pdo_pgsql \
    && apk del .phpize-deps \
    && rm -rf /usr/local/etc/php-fpm.d \
    && rm -rf /tmp/* /var/cache/apk/*

COPY --chown=www-data php.ini /usr/local/etc/php/
COPY --chown=www-data php-fpm.conf /usr/local/etc/

WORKDIR /app

USER www-data

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

CMD ["php-fpm"]