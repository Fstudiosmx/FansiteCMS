# ============================================================
# FansiteCMS — Fly.io
# PHP 8.2 + Apache + Composer + Node 20 (Webpack Encore)
# ============================================================
FROM php:8.2-apache

# Extensiones PHP necesarias para Symfony
RUN apt-get update && apt-get install -y \
    git curl unzip libicu-dev libpq-dev libzip-dev libonig-dev libxml2-dev \
    && docker-php-ext-install intl pdo pdo_pgsql pdo_mysql zip opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Node 20 + Yarn (para Webpack Encore)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g yarn

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Apache: habilitar mod_rewrite y apuntar al DocumentRoot de Symfony
RUN a2enmod rewrite
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-enabled/000-default.conf

# PHP opcache recomendado para producción
RUN echo "opcache.enable=1\nopcache.memory_consumption=256\nopcache.max_accelerated_files=20000\nopcache.validate_timestamps=0" \
    >> /usr/local/etc/php/conf.d/opcache.ini

# Copiar código fuente
WORKDIR /var/www/html
COPY . .

# Dependencias PHP (sin dev)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Assets Webpack Encore
RUN yarn install --frozen-lockfile && yarn build

# Permisos para var/ (cache, logs)
RUN mkdir -p var && chown -R www-data:www-data var public

# Entrypoint: migraciones + arranque Apache
COPY .fly/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 8080
CMD ["/entrypoint.sh"]
