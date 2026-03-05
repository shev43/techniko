#!/bin/bash
set -e

# Configure Apache port from Railway's PORT env variable
if [ -n "$PORT" ]; then
    sed -i "s/Listen 80/Listen $PORT/g" /etc/apache2/ports.conf
    sed -i "s/*:80/*:$PORT/g" /etc/apache2/sites-available/000-default.conf
fi

# Run Laravel setup
php artisan migrate --force 2>/dev/null || true
php artisan config:cache 2>/dev/null || true
php artisan route:cache 2>/dev/null || true
php artisan storage:link 2>/dev/null || true

# Start Apache
exec apache2-foreground
