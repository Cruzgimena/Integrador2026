## Descarga y utiliza una imagen base oficial de PHP en su versión 8.4 que ya incluye
## el servidor web Apache preconfigurado.
FROM php:8.4-apache

## Actualiza el gestor de paquetes de Linux e instala dependencias del sistema operativo
## (librerías para manejar imágenes, texto, XML y utilidades zip).
## Laravel necesita estas librerías subyacentes.
RUN apt-get update && apt-get install -y \
libpng-dev \
libonig-dev \
libxml2-dev \
zip \
unzip

## Instala y habilita extensiones nativas de PHP necesarias para que Laravel pueda interactuar con la
## base de datos MySQL y procesar cadenas de texto complejas.
RUN docker-php-ext-install pdo_mysql mbstring

## Crea una variable de entorno que define que la carpeta public de tu proyecto será el directorio principal.
ENV APACHE_ROOT_DIR /var/www/html/public

## Modifica los archivos de configuración de Apache reemplazando la ruta por defecto (/var/www/html) por la
## definida en la variable anterior. Esto es necesario porque el punto de entrada de Laravel es public/index.php.
RUN sed -ri -e 's!/var/www/html!${APACHE_ROOT_DIR}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_ROOT_DIR}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

## Habilita el módulo de reescritura de URLs de Apache. Sin esto, el sistema de rutas de Laravel no funcionaría.
RUN a2enmod rewrite

## Define el directorio de trabajo dentro del contenedor. Los comandos siguientes se ejecutan asumiendo esta ubicación.
WORKDIR /var/www/html

## Copia todo el código de tu proyecto desde tu computadora hacia el directorio de trabajo del contenedor.
COPY . .
## Cambia el propietario de las carpetas storage y bootstrap/cache al usuario con el que se ejecuta Apache (www-data).
## Esto le otorga permisos de escritura a Laravel para guardar sesiones, cachés y logs.
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache