# Utiliza PHP 8.2 (compatible con tu proyecto Laravel)
FROM php:8.2-fpm

# Instala dependencias de Laravel
RUN apt-get update \
    && apt-get install -y libzip-dev zip unzip git curl \
    && docker-php-ext-install pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configura el directorio de trabajo
WORKDIR /var/www/html

# Copia el proyecto completo
COPY src /var/www/html

# —> AÑADE ESTO: crea las carpetas de cache/logs y dale permisos a www-data
RUN mkdir -p /var/www/html/bootstrap/cache \
    /var/www/html/storage/framework/{cache,sessions,views} \
    /var/www/html/storage/logs \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache /var/www/html/storage

# Asegura permisos (ya lo tenías, pero no basta sin las carpetas)
RUN chmod -R 775 /var/www/html/bootstrap/cache \
    /var/www/html/storage

# Permitir Composer como superusuario
ENV COMPOSER_ALLOW_SUPERUSER=1

# Instala dependencias de Laravel
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Expone el puerto 8000
EXPOSE 8000

# Comando por defecto para ejecutar el servidor de Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000