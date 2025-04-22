FROM php:8.3-apache

# Instala extensiones del sistema necesarias para Laravel + SQLite
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite zip mbstring

# Habilita mod_rewrite para Laravel
RUN a2enmod rewrite

# Instala Composer desde otra imagen
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia todos los archivos del proyecto
COPY . /var/www/html/

# Configura el DocumentRoot de Apache correctamente
COPY ./docker/apache/laravel.conf /etc/apache2/sites-available/000-default.conf

# Instala dependencias PHP
RUN composer install --no-dev --optimize-autoloader

# Establece permisos adecuados
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Exponer puerto del Apache
EXPOSE 80
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs
RUN npm install && npm run build
RUN php artisan config:cache
RUN php artisan route:cache
# Comando por defecto
CMD ["apache2-foreground"]
