FROM php:8.2-apache
RUN docker-php-ext-install pdo pdo_sqlite
COPY api/ /var/www/html/
RUN a2enmod rewrite
RUN mkdir -p /var/www/html/data && chown -R www-data:www-data /var/www/html/data