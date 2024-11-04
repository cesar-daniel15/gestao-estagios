# Usar uma imagem base do PHP com Apache
FROM php:8.2-apache

# Instalar extensões do PHP
RUN docker-php-ext-install pdo pdo_mysql

# Instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar Node.js e npm para Vite
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - && \
    apt-get install -y nodejs

# Copiar o conteúdo do seu projeto para a pasta do container
COPY . /var/www/html

# Definir permissões adequadas
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Instalar dependências do Composer
WORKDIR /var/www/html
RUN composer install --no-interaction --optimize-autoloader

# Instalar dependências do npm
RUN npm install

# Build do Vite
RUN npm run build
