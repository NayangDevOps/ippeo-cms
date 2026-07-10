# Cosmetic Products CMS Website

A complete **Laravel-based CMS** for managing a modern cosmetic products website with a beautiful green-themed UI. Built with Laravel, MySQL, Bootstrap, and includes a full-featured admin panel.

## Features

### Frontend Features
- ✅ Modern green-themed responsive design
- ✅ Homepage with hero slider, featured products, categories
- ✅ Product listing with filters (category, price, search)
- ✅ Product detail pages with gallery, reviews, variants
- ✅ Category pages
- ✅ Blog/News section
- ✅ Contact form with inquiry management
- ✅ FAQ page
- ✅ Newsletter subscription
- ✅ Dynamic CMS pages
- ✅ SEO-friendly URLs
- ✅ Mobile-responsive design

### Admin Panel Features
- ✅ Secure admin authentication
- ✅ Dashboard with statistics
- ✅ Complete product management (CRUD, variants, images, tags)
- ✅ Category management with hierarchy support
- ✅ Tag management
- ✅ Review moderation
- ✅ Banner management for homepage slider
- ✅ Testimonials management
- ✅ Blog management
- ✅ FAQ management
- ✅ CMS pages editor
- ✅ Contact inquiry tracking
- ✅ Newsletter subscriber management
- ✅ Homepage sections customization
- ✅ Site settings management
- ✅ User management

### Product Features
- Multiple product images
- Product variants (size, color, scent)
- Sale prices with discount calculation
- Stock management
- Featured/New/Bestseller flags
- Product ratings and reviews
- Tags and categories
- SEO meta fields
- Related products

## Tech Stack

- **Backend**: Laravel 11 (PHP 8.2+)
- **Database**: MySQL
- **Frontend**: Bootstrap 5, Custom CSS
- **Icons**: Font Awesome 6
- **JavaScript**: jQuery, AJAX
- **Architecture**: MVC Pattern

## Requirements

- PHP >= 8.2
- Composer
- MySQL/MariaDB
- Apache/Nginx with mod_rewrite
- Node.js & NPM (optional, for asset compilation)

## Installation

### 1. Clone/Download the Project

```bash
# If using Git
git clone your-repo-url cosmetic-cms
cd cosmetic-cms

# Or extract the ZIP file
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install NPM dependencies (optional)
npm install
```

### 3. Environment Configuration

```bash
# Copy environment file
copy .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Database

Edit `.env` file and set your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cosmetic_cms
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Create Database

Create a new MySQL database:

```sql
CREATE DATABASE cosmetic_cms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 6. Run Migrations & Seeders

```bash
# Run migrations to create tables
php artisan migrate

# Seed the database with sample data
php artisan db:seed
```

### 7. Create Storage Link

```bash
# Create symbolic link for file uploads
php artisan storage:link
```

### 8. Set Permissions (Linux/Mac)

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 9. Serve the Application

```bash
# Using PHP built-in server
php artisan serve

# Or configure Apache/Nginx virtual host
```

## Default Credentials

### Admin Panel
- **URL**: http://localhost:8000/admin/login
- **Email**: admin@admin.com
- **Password**: password

### Test User
- **Email**: john@example.com
- **Password**: password

## Directory Structure

```
cosmetic-cms/
├── app/
│   ├── Http/
│   │   ├── Controllers/          # Frontend controllers
│   │   │   └── Admin/           # Admin panel controllers
│   │   └── Middleware/          # Custom middleware
│   └── Models/                  # Eloquent models
├── database/
│   ├── migrations/              # Database migrations
│   └── seeders/                 # Database seeders
├── public/
│   ├── css/                     # Stylesheets
│   │   ├── frontend-style.css   # Frontend green theme
│   │   └── admin-style.css      # Admin panel styles
│   └── images/                  # Public images
├── resources/
│   └── views/
│       ├── layouts/             # Layout files
│       ├── frontend/            # Frontend views
│       └── admin/               # Admin panel views
└── routes/
    ├── web.php                  # Web routes
    └── api.php                  # API routes
```

## Database Schema

### Main Tables

1. **users** - User management (admin & customers)
2. **categories** - Product categories with hierarchy
3. **products** - Main products table
4. **product_images** - Product gallery images
5. **product_variants** - Product variations
6. **tags** - Product tags
7. **reviews** - Product reviews
8. **banners** - Homepage slider
9. **testimonials** - Customer testimonials
10. **blogs** - Blog/news articles
11. **faqs** - Frequently asked questions
12. **cms_pages** - Dynamic CMS pages
13. **contact_inquiries** - Contact form submissions
14. **newsletters** - Newsletter subscribers
15. **site_settings** - Site configuration
16. **homepage_sections** - Homepage content sections

## Key Features Implementation

### Image Upload System
- Images stored in `storage/app/public/`
- Automatic thumbnail generation
- Support for multiple images per product

### SEO Optimization
- Meta titles, descriptions, keywords for products
- SEO-friendly slugs
- Dynamic sitemap support
- Open Graph meta tags

### Admin Panel Security
- Admin middleware protection
- Role-based access control
- Session management
- CSRF protection

### Product Filters
- Category filter
- Price range filter
- Search functionality
- Sorting options (latest, price, popularity, rating)

### Review System
- Star rating (1-5)
- Admin approval required
- Automatic rating calculation
- Review moderation

## Customization

### Change Theme Colors

Edit `public/css/frontend-style.css`:

```css
:root {
    --green-primary: #2d6a4f;    /* Main green color */
    --green-dark: #1b4332;       /* Darker green */
    --green-light: #52b788;      /* Light green */
    --green-lighter: #95d5b2;    /* Lighter green */
}
```

### Add New Admin Menu Items

Edit `resources/views/layouts/admin.blade.php` in the sidebar section.

### Modify Homepage Sections

Use Admin Panel → Homepage Sections to add/edit content blocks.

## API Endpoints (Future)

The structure supports API development:
- `/api/products` - Product listing
- `/api/categories` - Category listing
- `/api/products/{slug}` - Product details

## Performance Optimization

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer dump-autoload --optimize
```

## Clear Cache

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## Backup

```bash
# Backup database
mysqldump -u root -p cosmetic_cms > backup.sql

# Backup files
tar -czf backup-files.tar.gz public/storage/
```

## Troubleshooting

### Issue: 404 on all pages except homepage
**Solution**: Enable mod_rewrite and ensure `.htaccess` exists in public folder

### Issue: Images not showing
**Solution**: Run `php artisan storage:link`

### Issue: Permission denied errors
**Solution**: Set proper permissions on storage and bootstrap/cache

### Issue: SQLSTATE errors
**Solution**: Check database credentials in `.env` file

## Support & Documentation

- Laravel Docs: https://laravel.com/docs
- Bootstrap Docs: https://getbootstrap.com/docs

## License

This project is open-source software licensed under the MIT license.

## Credits

- Laravel Framework
- Bootstrap CSS Framework
- Font Awesome Icons
- Google Fonts (Playfair Display, Poppins)

---

**Developed by**: Senior Full Stack Developer
**Version**: 1.0.0
**Last Updated**: June 2026
