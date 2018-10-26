FROM webdevops/php-nginx:alpine-php7

# tell debian we want as less interaction as possible
ENV DEBIAN_FRONTEND noninteractive

# install packages
COPY src /var/www

# set the workdir
WORKDIR /var/www

# install php dependencies
RUN wget https://getcomposer.org/download/1.7.2/composer.phar && php composer.phar install && rm composer.phar && \
# prepare laravel app
    cp .env.production .env && php artisan key:generate && \
    chmod -R 777 storage bootstrap/cache

EXPOSE 80 443