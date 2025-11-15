FROM php:8.2-apache

# Cài extension cho Laravel
RUN docker-php-ext-install pdo pdo_pgsql

# Bật mod_rewrite để Laravel chạy route chuẩn
RUN a2enmod rewrite

WORKDIR /var/www/html

# Copy code vào container
COPY . .

# Cài composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Cài vendor + build Laravel
RUN composer install --no-dev --optimize-autoloader \
 && php artisan key:generate --force \
 && php artisan config:cache \
 && php artisan route:cache

# Đặt document root là thư mục public/
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/000-default.conf /etc/apache2/apache2.conf

EXPOSE 80

CMD ["apache2-foreground"]
