#Se utiliza la imagen oficial de PHP 8.2 en modo CLI
FROM php:8.2-cli

#Se establece el directorio de trabajo dentro del contenedor
WORKDIR /var/www/html

#Se copia todos los archivos del proyecto al directorio de trabajo del contenedor
COPY . .

#Actualiza los paquetes del sistema e instala sqlite3 y librerías necesarias
RUN apt-get update && \
    apt-get install -y sqlite3 libsqlite3-dev && \
    docker-php-ext-install pdo pdo_sqlite

#Se expone el puerto 8080, que es donde el servidor PHP escuchará    
EXPOSE 8080

#Con este comando se incia un servidor web embebido de PHP escuchando en 0.0.0.0:8080 y sirviendo archivos desde la carpeta public
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
