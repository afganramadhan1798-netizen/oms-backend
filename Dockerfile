FROM composer:2.8 AS composer_deps

WORKDIR /app

COPY . .
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --prefer-dist \
    --optimize-autoloader

FROM node:22-alpine AS frontend_builder

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY resources resources
COPY public public
COPY vite.config.js ./
RUN npm run build

FROM php:8.2-fpm-alpine

WORKDIR /usr/src/app

RUN apk add --no-cache \
      fcgi \
      libzip-dev \
      unzip \
    && docker-php-ext-install -j1 \
      bcmath \
      pdo_mysql \
      zip \
    && rm -rf /var/cache/apk/*

COPY . .
COPY --from=composer_deps /app/vendor ./vendor
COPY --from=frontend_builder /app/public/build ./public/build

RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache \
    && chown -R www-data:www-data /usr/src/app \
    && chmod -R 775 storage bootstrap/cache

WORKDIR /var/www/html

EXPOSE 9000

CMD ["php-fpm"]
