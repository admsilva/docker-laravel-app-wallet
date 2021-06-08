FROM php:8.0-fpm

ARG USER
ARG GROUP
ARG CONFIG_FOLDER

ADD $CONFIG_FOLDER/php-fpm/www.conf /usr/local/etc/php-fpm.d/

RUN apt-get update && \
      apt-get install -y git && \
      apt-get install -y curl && \
      apt-get install -y libpng-dev && \
      apt-get install -y libonig-dev && \
      apt-get install -y libxml2-dev && \
      apt-get install -y zip && \
      apt-get install -y unzip && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/* && \
      docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd && \
      mkdir -p /var/www/html && \
      useradd -ms /bin/bash $USER && \
      gpasswd -a $USER root && \
      chown -R $USER:$GROUP /var/www/html && \
      chmod -R 775 /var/www/html