@echo off
echo ========================================
echo Cosmetic CMS - Installation Script
echo ========================================
echo.

echo [1/7] Installing Composer dependencies...
call composer install
if errorlevel 1 goto error

echo.
echo [2/7] Copying environment file...
if not exist .env (
    copy .env.example .env
    echo .env file created
) else (
    echo .env file already exists
)

echo.
echo [3/7] Generating application key...
call php artisan key:generate
if errorlevel 1 goto error

echo.
echo [4/7] Running database migrations...
call php artisan migrate
if errorlevel 1 goto error

echo.
echo [5/7] Seeding database with sample data...
call php artisan db:seed
if errorlevel 1 goto error

echo.
echo [6/7] Creating storage link...
call php artisan storage:link
if errorlevel 1 goto error

echo.
echo [7/7] Clearing caches...
call php artisan cache:clear
call php artisan config:clear
call php artisan view:clear

echo.
echo ========================================
echo Installation completed successfully!
echo ========================================
echo.
echo Your website is ready to use!
echo.
echo Frontend: http://localhost:8000
echo Admin Panel: http://localhost:8000/admin/login
echo.
echo Default Admin Credentials:
echo Email: admin@admin.com
echo Password: password
echo.
echo To start the development server, run:
echo php artisan serve
echo.
pause
goto end

:error
echo.
echo ========================================
echo Installation failed!
echo ========================================
echo Please check the error messages above
echo and ensure:
echo - PHP 8.2+ is installed
echo - Composer is installed
echo - MySQL database 'cosmetic_cms' exists
echo - Database credentials in .env are correct
echo.
pause

:end
