# --- Etapa 1: construir assets con Vite ---
FROM node:20-bookworm AS assets
WORKDIR /app
# Copiamos sólo lo necesario para cachear npm ci
COPY src/package*.json ./
RUN npm ci
# Ahora el resto del código (para que Vite encuentre resources/)
COPY src .
RUN npm run build  # genera /app/public/build

# --- Etapa 2: PHP + Composer ---
FROM php:8.3-fpm-bookworm

ARG DEBIAN_FRONTEND=noninteractive

RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
        libzip-dev unzip git curl; \
    docker-php-ext-configure zip; \
    docker-php-ext-install -j"$(nproc)" pdo_mysql zip; \
    rm -rf /var/lib/apt/lists/*

ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copia composer.* primero para cachear vendor
COPY src/composer.json src/composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader || true

# Copia el resto del proyecto
COPY src .

# Directorios y permisos
RUN mkdir -p bootstrap/cache \
    storage/framework/{cache,sessions,views} storage/logs \
 && chown -R www-data:www-data bootstrap/cache storage \
 && chmod -R 775 bootstrap/cache storage

# Copia el build de Vite a public/build
COPY --from=assets /app/public/build /var/www/html/public/build

# Asegura que no quede "hot" (modo dev)
RUN rm -f public/hot || true

EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000