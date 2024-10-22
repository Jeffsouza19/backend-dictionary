#!/bin/bash

# Ajustar permissões para o diretório storage
chown -R sail:sail /var/www/html/storage
chmod -R 775 /var/www/html/storage

# Limpar caches do Laravel
php artisan cache:clear
php artisan config:clear
php artisan view:clear

echo "Configuração concluída."
