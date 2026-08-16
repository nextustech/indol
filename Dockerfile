# ============================================================================
# Indolia (Rx Physio) - production Docker image
# Single container: nginx + PHP-FPM managed by supervisord.
# The queue worker runs as a separate service from the same image.
# ============================================================================

######################
# Build frontend     #
######################
FROM node:18-alpine AS frontend

WORKDIR /app
COPY package.json package-lock.json vite.config.js ./
COPY resources ./resources
RUN npm ci && npm run build

######################
# Runtime image      #
######################
FROM php:8.2-fpm

# System packages + PHP extensions required by the application
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        nginx \
        supervisor \
        default-mysql-client \
        curl \
        git \
        unzip \
        libzip-dev \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libicu-dev \
        libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_mysql \
        bcmath \
        exif \
        gd \
        intl \
        mbstring \
        opcache \
        pcntl \
        posix \
        zip \
    && apt-get purge -y --auto-remove \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Config files
COPY docker/php.ini      /usr/local/etc/php/conf.d/zz-app.ini
COPY docker/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/nginx.conf   /etc/nginx/conf.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Remove default nginx site and duplicate PHP-FPM pool files shipped by the
# base images so only our configurations are active.
RUN rm -f /etc/nginx/sites-enabled/default \
          /usr/local/etc/php-fpm.d/zz-docker.conf \
          /usr/local/etc/php-fpm.d/docker.conf

# Application code (excludes .env, vendor, storage caches per .dockerignore)
COPY --chown=www-data:www-data . /var/www/html
COPY --chown=www-data:www-data --from=frontend /app/public/build /var/www/html/public/build

# Install PHP dependencies with the exact runtime PHP (8.2) instead of the
# composer image (whose PHP tracks latest). Copy the self-contained composer
# phar from the official composer image.
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1 COMPOSER_HOME=/tmp
RUN composer install \
        --no-dev \
        --no-scripts \
        --no-interaction \
        --no-progress \
        --optimize-autoloader \
    && rm -f /usr/local/bin/composer

COPY docker/entrypoint.sh /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint \
    && mkdir -p /var/run/php /var/log/nginx \
    && chown -R www-data:www-data /var/www/html

EXPOSE 80

ENTRYPOINT ["entrypoint"]
CMD ["supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]