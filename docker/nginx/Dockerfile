FROM nginx:latest

ARG USER
ARG GROUP
ARG CONFIG_FOLDER

ADD $CONFIG_FOLDER/nginx/nginx.conf /etc/nginx/
ADD $CONFIG_FOLDER/nginx/default.conf /etc/nginx/conf.d/

RUN mkdir -p /var/www/html && \
    useradd -ms /bin/bash $USER && \
    gpasswd -a $USER root && \
    chown -R $USER:$GROUP /var/www/html && \
    chmod -R 775 /var/www/html && \
    chgrp -R $USER /var/cache/nginx /var/run /var/log/nginx && \
    chmod -R 770 /var/cache/nginx /var/run /var/log/nginx