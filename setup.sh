#!/bin/bash

# Sair imediatamente se um comando falhar
set -e

# Instalar as dependências do Composer
echo "A instalar as dependências do Composer..."
composer install

# Instalar as dependências do Node
echo "A instalar as dependências do Node..."
npm install

# Subir os containers
echo "A subir os containers..."
docker-compose up -d

# Executar migrations
echo "A executar as migrations..."
docker exec -it app php artisan migrate --seed

# Rodar Vite
echo "A iniciar o Vite..."
npm run dev

echo "Configuração completa!"
