FROM webdevops/php:8.1-alpine AS builder
WORKDIR /app
COPY src .
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev

FROM webdevops/php-nginx:8.1-alpine
WORKDIR /var/www
COPY --from=builder /app .
# prepare laravel app
RUN cp .env.production .env && php artisan key:generate && \
    chmod -R 777 storage bootstrap/cache
EXPOSE 80 443