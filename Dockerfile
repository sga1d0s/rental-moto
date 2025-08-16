# Dockerfile
FROM php:8.3-fpm-bookworm

# Evita prompts de apt
ARG DEBIAN_FRONTEND=noninteractive

# Dependencias de sistema mínimas
RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
        libzip-dev \
        unzip \
        git \
        curl; \
    # zip de PHP necesita configurarse antes de compilar
    docker-php-ext-configure zip; \
    docker-php-ext-install -j"$(nproc)" \
        pdo_mysql \
        zip; \
    # Limpieza
    rm -rf /var/lib/apt/lists/*


# Composer (sin root warnings)
ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Directorio de la app
WORKDIR /var/www/html

# Copia el proyecto completo
COPY src /var/www/html

# Copia de dependencias primero para cachear
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader || true

# —> AÑADE ESTO: crea las carpetas de cache/logs y dale permisos a www-data
RUN mkdir -p /var/www/html/bootstrap/cache \
    /var/www/html/storage/framework/{cache,sessions,views} \
    /var/www/html/storage/logs \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache /var/www/html/storage

# Asegura permisos (ya lo tenías, pero no basta sin las carpetas)
RUN chmod -R 775 /var/www/html/bootstrap/cache \
    /var/www/html/storage

# Instala dependencias de Laravel
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Expone el puerto 8000
EXPOSE 8000

# Comando por defecto para ejecutar el servidor de Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000