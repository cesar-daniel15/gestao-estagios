# Imagem do PHP
FROM php:8.2-apache

# Instalar extensões necessarias
RUN docker-php-ext-install pdo pdo_mysql

RUN a2enmod rewrite

# Instalar dependecias do sistema
RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    && apt-get clean

# Instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Pasta do trabalho
WORKDIR /var/www/html

# Copiar os arquivos do projeto para o container
COPY . .

# Instalar dependeicas do Laravel
RUN composer install --no-interaction --prefer-dist

# Permissoes
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public

# Expor porta 80
EXPOSE 80

# Iniciar o Apache
CMD ["apache2-foreground"]