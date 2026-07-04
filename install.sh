#!/bin/bash

echo "========================================"
echo "Cosmetic CMS - Installation Script"
echo "========================================"
echo ""

echo "[1/7] Installing Composer dependencies..."
composer install
if [ $? -ne 0 ]; then
    echo "Error: Composer install failed"
    exit 1
fi

echo ""
echo "[2/7] Copying environment file..."
if [ ! -f .env ]; then
    cp .env.example .env
    echo ".env file created"
else
    echo ".env file already exists"
fi

echo ""
echo "[3/7] Generating application key..."
php artisan key:generate
if [ $? -ne 0 ]; then
    echo "Error: Key generation failed"
    exit 1
fi

echo ""
echo "[4/7] Running database migrations..."
php artisan migrate
if [ $? -ne 0 ]; then
    echo "Error: Migration failed"
    exit 1
fi

echo ""
echo "[5/7] Seeding database with sample data..."
php artisan db:seed
if [ $? -ne 0 ]; then
    echo "Error: Seeding failed"
    exit 1
fi

echo ""
echo "[6/7] Creating storage link..."
php artisan storage:link
if [ $? -ne 0 ]; then
    echo "Warning: Storage link creation failed (may already exist)"
fi

echo ""
echo "[7/7] Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear

echo ""
echo "========================================"
echo "Installation completed successfully!"
echo "========================================"
echo ""
echo "Your website is ready to use!"
echo ""
echo "Frontend: http://localhost:8000"
echo "Admin Panel: http://localhost:8000/admin/login"
echo ""
echo "Default Admin Credentials:"
echo "Email: admin@admin.com"
echo "Password: password"
echo ""
echo "To start the development server, run:"
echo "php artisan serve"
echo ""
