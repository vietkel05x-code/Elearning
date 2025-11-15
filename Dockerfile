FROM php:8.2-apache

# Cài thư viện hệ thống + extension PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
 && docker-php-ext-install pdo_pgsql \
 && docker-php-ext-enable pdo_pgsql \
 && a2enmod rewrite \
 && rm -rf /var/lib/apt/lists/*

# Thư mục làm việc
WORKDIR /var/www/html

# Copy source vào container
COPY . .

# Cài composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Cài vendor (KHÔNG chạy php artisan ở bước build)
RUN composer install --no-dev --optimize-autoloader

# Quyền ghi cho Laravel (storage, cache)
RUN chown -R www-data:www-data storage bootstrap/cache

# Đặt document root là thư mục public/
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/000-default.conf /etc/apache2/apache2.conf

# Script start: migrate + cache + chạy Apache
RUN printf '%s\n' \
 '#!/bin/sh' \
 'set -e' \
 'cd /var/www/html' \
 'php artisan migrate --force || true' \
 'php artisan config:cache || true' \
 'php artisan route:cache || true' \
 'exec apache2-foreground' > /usr/local/bin/start.sh \
 && chmod +x /usr/local/bin/start.sh

EXPOSE 80

CMD ["start.sh"]
