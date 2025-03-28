FROM php:8.2-cli

WORKDIR /var/www/html

COPY . .

RUN apt-get update && \
    apt-get install -y sqlite3 libsqlite3-dev && \
    docker-php-ext-install pdo pdo_sqlite

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
