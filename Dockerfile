FROM php:8.1-apache
RUN docker-php-ext-install pdo pdo_mysql
COPY . /var/www/html/
RUN echo "DirectoryIndex Index.php index.php index.html" > /etc/apache2/conf-enabled/directoryindex.conf
EXPOSE 80