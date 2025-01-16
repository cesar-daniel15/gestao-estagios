# Usar a imagem do PHP com FPM
FROM php:8.2-fpm

# Instalar extensões necessárias
RUN docker-php-ext-install pdo pdo_mysql

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    curl \  
    git \   
    unzip \ 
    && apt-get clean 

# Instalar Node.js e npm
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs  # Instalar Node.js e npm

# Instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Definir a pasta de trabalho
WORKDIR /var/www/html 

# Copiar os ficheiros do projeto para o container
COPY . . 

# Criar pastas necessarias
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public

# Instalar dependências do Laravel
RUN composer install --no-interaction --prefer-dist 

RUN npm install && npm run build

# Ajustar permissões
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public  # Ajustar permissões para o usuário www-data

# Expor a porta 9000 para o PHP-FPM
EXPOSE 9000  

# Iniciar o PHP-FPM
CMD ["php-fpm"]  