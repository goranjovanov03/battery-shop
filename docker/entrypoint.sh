#!/bin/sh

set -e

echo "Starting Laravel Battery Shop..."

# Wait for database
echo "Waiting for database..."
until nc -z mysql 3306; do
    sleep 1
done
echo "Database is ready!"

# Clear any cached config that might reference missing providers
echo "Clearing cache..."
rm -f bootstrap/cache/*.php
rm -rf storage/framework/cache/data/*

# Generate key if not set
if [ -z "$APP_KEY" ]; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Seed database if empty
if [ "$SEED_DATABASE" = "true" ]; then
    echo "Seeding database..."
    php artisan db:seed --force
fi

# Optimize for production
echo "Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Create storage link
php artisan storage:link

# Set permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Start PHP-FPM in background
echo "Starting PHP-FPM..."
php-fpm -D

# Start Nginx in foreground
echo "Starting Nginx..."
exec nginx -g "daemon off;"