FROM composer:latest

ARG UID
ARG USER
ARG GID
ARG GROUP

RUN addgroup --gid $GID $GROUP && \ 
    adduser -u $UID -G $GROUP -s /bin/bash -D $USER