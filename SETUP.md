# Quick Setup Guide

## Prerequisites
- PHP 8.2 or higher
- MySQL 5.7 or higher
- Composer
- Apache/Nginx with mod_rewrite enabled

## Quick Start Steps

### 1. Database Setup
```bash
# Login to MySQL
mysql -u root -p

# Create database
CREATE DATABASE cosmetic_cms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### 2. Configure Environment
```bash
# Copy .env file
copy .env.example .env

# Edit .env and set:
DB_DATABASE=cosmetic_cms
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 3. Install & Setup
```bash
# Install dependencies
composer install

# Generate key
php artisan key:generate

# Run migrations
php artisan migrate

# Seed database with sample data
php artisan db:seed

# Create storage link
php artisan storage:link
```

### 4. Run Application
```bash
# Development server
php artisan serve

# Visit: http://localhost:8000
# Admin: http://localhost:8000/admin/login
```

### 5. Login to Admin Panel
- URL: http://localhost:8000/admin/login
- Email: admin@admin.com
- Password: password

## Production Deployment

### Apache Configuration
```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /path/to/cosmetic-cms/public

    <Directory /path/to/cosmetic-cms/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### Nginx Configuration
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/cosmetic-cms/public;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### Permissions (Linux)
```bash
sudo chown -R www-data:www-data /path/to/cosmetic-cms
sudo chmod -R 755 /path/to/cosmetic-cms
sudo chmod -R 775 /path/to/cosmetic-cms/storage
sudo chmod -R 775 /path/to/cosmetic-cms/bootstrap/cache
```

### Production .env Settings
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

### Optimize for Production
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Common Issues

### 500 Internal Server Error
- Check file permissions
- Check Apache/Nginx logs
- Ensure .env is configured correctly

### Database Connection Error
- Verify MySQL is running
- Check database credentials in .env
- Ensure database exists

### Images Not Showing
- Run: php artisan storage:link
- Check storage/app/public permissions

### Admin Login Not Working
- Clear cache: php artisan cache:clear
- Check if user exists in database
- Verify password hash

## Features Demo

### Sample Products
The seeder creates 6 sample products across different categories.

### Sample Data Includes:
- 1 Admin user
- 1 Regular user
- 6 Categories
- 6 Products with variants
- 6 Tags
- 2 Banners
- 3 Testimonials
- 1 Blog post
- 4 FAQs
- 3 CMS pages
- Site settings

## Next Steps

1. ✅ Upload product images via admin panel
2. ✅ Create more categories and products
3. ✅ Write blog posts
4. ✅ Add more FAQs
5. ✅ Customize site settings
6. ✅ Set up email configuration for contact forms
7. ✅ Add Google Analytics
8. ✅ Configure payment gateway (if needed)
9. ✅ Set up SSL certificate
10. ✅ Configure backups

## Support

For issues or questions:
- Check README.md for detailed documentation
- Review Laravel documentation: https://laravel.com/docs
- Check error logs: storage/logs/laravel.log

---

Good luck with your cosmetic website! 🌿
