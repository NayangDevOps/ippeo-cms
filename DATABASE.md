# Cosmetic CMS - Database Structure

## Database: cosmetic_cms

### Tables Overview

1. users - User accounts (admin & customers)
2. categories - Product categories
3. products - Main products
4. product_images - Product gallery
5. product_variants - Product variations
6. tags - Product tags
7. product_tag - Pivot table
8. reviews - Product reviews
9. banners - Homepage slider
10. testimonials - Customer testimonials
11. blogs - Blog posts
12. faqs - FAQs
13. cms_pages - Dynamic pages
14. contact_inquiries - Contact forms
15. newsletters - Email subscribers
16. site_settings - Site configuration
17. homepage_sections - Homepage content
18. password_reset_tokens - Password reset
19. sessions - User sessions

## Table Relationships

### products
- belongsTo: categories
- hasMany: product_images, product_variants, reviews
- belongsToMany: tags

### categories
- belongsTo: categories (parent)
- hasMany: categories (children), products

### reviews
- belongsTo: products, users

### blogs
- belongsTo: users (author)

## Default Admin Credentials

**Email**: admin@admin.com
**Password**: password
**Role**: admin

## Sample Data

After running `php artisan migrate:fresh --seed`:

| Entity | Count |
|--------|-------|
| Users | 6 (1 admin, 5 customers) |
| Categories | 13 (6 parent + 7 subcategories) |
| Products | 12 |
| Product images | 36 (featured + gallery per product) |
| Product variants | 2 |
| Tags | 10 |
| Reviews | ~36 (2-4 per product) |
| Banners | 3 |
| Testimonials | 6 |
| Blog posts | 5 |
| FAQs | 8 |
| CMS pages | 4 |
| Site settings | 16 (incl. logo & favicon) |
| Homepage sections | 2 |
| Newsletter subscribers | 5 |
| Contact inquiries | 5 |

All images are auto-generated JPEG/PNG placeholders in `storage/app/public/` (products, categories, banners, blogs, testimonials, settings, homepage).

## Product Structure

Each product includes:
- Basic info (name, SKU, price, stock)
- Images (featured + gallery)
- Content (description, ingredients, benefits, usage)
- Flags (featured, new, bestseller, active)
- SEO (meta title, description, keywords)
- Stats (views, rating, reviews count)

## Category Structure

Categories support:
- Unlimited nesting (parent-child)
- Custom ordering
- SEO fields
- Active/inactive status

## Important Notes

1. All user passwords are hashed using bcrypt
2. Images are stored in storage/app/public/
3. Soft deletes enabled for products
4. Timestamps on all tables
5. Foreign key constraints in place
