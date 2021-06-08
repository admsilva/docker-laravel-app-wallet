FROM mysql:latest

ARG USER
ARG GROUP

RUN useradd -ms /bin/bash $USER && \
    chown -R $USER:$GROUP /var/lib/mysql && \
    chmod -R 775 /var/lib/mysql