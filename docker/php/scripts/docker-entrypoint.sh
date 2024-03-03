#!/usr/bin/env sh
set -e

cp .env.example .env
composer install
php artisan key:generate

exec php-fpm -c /usr/local/etc/php-fpm.conf