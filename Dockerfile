# Mulai dari image PHP-Apache yang sudah kita gunakan
FROM php:8.2-apache

# Instal ekstensi pdo_mysql yang dibutuhkan untuk koneksi ke MySQL
RUN docker-php-ext-install pdo_mysql

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

COPY . /var/www/html/