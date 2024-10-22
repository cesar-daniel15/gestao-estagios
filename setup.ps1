# Instalar dependências do Composer
Write-Host "A instalar as dependências do Composer..."
composer install

# Instalar dependências do Node
Write-Host "A instalar as dependências do Node..."
npm install

# Subir os containers
Write-Host "A subir os containers..."
docker-compose up -d

# Executar migrations
Write-Host "A executar as migrations..."
docker exec -it app php artisan migrate --seed

# Rodar Vite
Write-Host "A iniciar o Vite..."
npm run dev

Write-Host "Configuração completa!"
