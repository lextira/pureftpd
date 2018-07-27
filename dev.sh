#!/usr/bin/env bash

docker run -d \
    -v $PWD/src:/var/www \
    -e "WEB_DOCUMENT_ROOT=/var/www/public" \
    -e "WEB_DOCUMENT_INDEX=index.php" \
    -e "WEB_ALIAS_DOMAIN=localhost" \
    -p 80:80 \
    webdevops/php-nginx:alpine-php7

