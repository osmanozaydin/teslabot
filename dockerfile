FROM php:8.2-apache

# Gerekli sistem paketlerini yükle (libcurl-dev dahil)
RUN apt-get update && \
    apt-get install -y libcurl4-openssl-dev pkg-config && \
    docker-php-ext-install curl

# Tüm PHP dosyalarını Apache dizinine kopyala
COPY . /var/www/html/

EXPOSE 80
