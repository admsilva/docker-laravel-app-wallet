FROM php:8.3-fpm-alpine

ARG USER
ARG GROUP

ENV COMPOSER_VERSION 2.8.1

RUN apk --update add --no-cache --no-progress \
      ${PHPIZE_DEPS} \
      git \
      curl \
      libpng-dev \
      oniguruma \
      oniguruma-dev \
      libxml2-dev \
      zip \
      bash \
      unzip && \
      rm -rf /var/lib/apt/lists/* && \
      docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd && \
      pecl install pcov && \
      docker-php-ext-enable pcov && \
      mkdir -p /var/www/html && \
      addgroup -g 1000 -S $GROUP && \
      adduser -u 1000 -D -S -G $USER -h /app -g $GROUP $USER && \
      chown -R $USER:$GROUP /var/www/html && \
      chmod -R 775 /var/www/html && \
      curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=$COMPOSER_VERSION && \
      composer --version

COPY ./docker/php/config/ /
COPY ./docker/php/scripts/ /

RUN chmod +x /docker-entrypoint.sh

ENTRYPOINT ["sh", "-c", "/docker-entrypoint.sh \"${USER}\" ${GROUP}"]