#!/bin/sh
set -e

echo ">>> FansiteCMS arrancando en Fly.io..."

# Cambiar puerto Apache a 8080 (requerido por Fly.io)
sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf
sed -i 's/:80>/:8080>/' /etc/apache2/sites-enabled/000-default.conf

# Limpiar y calentar cache de Symfony
php bin/console cache:clear --env=prod --no-debug || true
php bin/console cache:warmup --env=prod --no-debug || true

# Ejecutar migraciones automáticamente
php bin/console doctrine:migrations:migrate --no-interaction --env=prod || true

echo ">>> Iniciando Apache en puerto 8080"
exec apache2-foreground
