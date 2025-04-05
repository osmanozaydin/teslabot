FROM php:8.2-apache

# Dosyaları Apache kök dizinine kopyala
COPY . /var/www/html/

# Gerekirse cURL eklentisini aktif et
RUN docker-php-ext-install curl

EXPOSE 80
