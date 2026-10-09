# ─── Stage 1: Node build (compile frontend assets) ───────────────────────────
FROM node:18-alpine AS node_build
WORKDIR /app
COPY package*.json ./
COPY . .
RUN rm -rf node_modules && npm ci && ./node_modules/.bin/mix --production

# ─── Stage 2: PHP / Laravel production image ──────────────────────────────────
FROM php:8.1-fpm-alpine

# System deps
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    mysql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
        opcache

# Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy app source
COPY . .

# Copy compiled frontend assets from Stage 1
COPY --from=node_build /app/public/js  ./public/js
COPY --from=node_build /app/public/css ./public/css
COPY --from=node_build /app/public/mix-manifest.json ./public/mix-manifest.json

# Install PHP dependencies (no dev)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Nginx config
COPY docker/nginx/default.conf /etc/nginx/http.d/default.conf

# Supervisor config (runs php-fpm + nginx together)
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
