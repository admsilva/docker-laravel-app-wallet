FROM nginx:alpine

ARG USER
ARG GROUP

RUN mkdir -p /var/www/html && \
    addgroup -g 1000 -S $GROUP && \
    adduser -u 1000 -D -S -G $USER -h /app -g $GROUP $USER && \
    chown -R $USER:$GROUP /var/www/html && \
    chmod -R 775 /var/www/html && \
    chgrp -R $USER /var/cache/nginx /var/run /var/log/nginx && \
    chmod -R 770 /var/cache/nginx /var/run /var/log/nginx

COPY ./docker/nginx/config/ /
COPY ./docker/nginx/scripts/ /

RUN chmod +x /docker-entrypoint.sh

ENTRYPOINT ["sh", "-c", "/docker-entrypoint.sh \"${USER}\" ${GROUP}"]