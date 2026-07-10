#!/bin/bash

# Ippeo CMS Deployment Script
# Run this on the server after git pull

set -e

echo "Starting deployment..."

# Pull latest code
git pull origin main

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Create storage symlink if missing
if [ ! -L "public/storage" ]; then
    php artisan storage:link --force
    echo "Storage symlink created."
fi

# Ensure storage directories exist
mkdir -p storage/app/public/banners
mkdir -p storage/app/public/products
mkdir -p storage/app/public/categories
mkdir -p storage/app/public/blogs
mkdir -p storage/app/public/settings
mkdir -p storage/app/public/testimonials
mkdir -p storage/app/public/homepage
mkdir -p storage/app/public/dummy

# Set permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Cache config and routes
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations
php artisan migrate --force

echo "Deployment complete!"
