<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\CmsPage;
use App\Models\ContactInquiry;
use App\Models\Faq;
use App\Models\HomepageSection;
use App\Models\Newsletter;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Review;
use App\Models\SiteSetting;
use App\Models\Tag;
use App\Models\Testimonial;
use App\Models\User;
use App\Support\DummyImageGenerator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DummyDataSeeder extends Seeder
{
    private DummyImageGenerator $images;

    public function run(): void
    {
        $this->images = new DummyImageGenerator;

        $this->seedUsers();
        $categories = $this->seedCategories();
        $tags = $this->seedTags();
        $products = $this->seedProducts($categories, $tags);
        $this->seedReviews($products);
        $this->seedBanners();
        $this->seedTestimonials();
        $this->seedBlogs();
        $this->seedFaqs();
        $this->seedCmsPages();
        $this->seedSiteSettings();
        $this->seedHomepageSections();
        $this->seedNewsletters();
        $this->seedContactInquiries();

        $this->command?->info('Dummy data seeded successfully with images.');
    }

    private function seedUsers(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+1 (555) 100-0001',
            'address' => '123 Beauty Street, New York, NY 10001',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $customers = [
            ['name' => 'John Doe', 'email' => 'john@example.com'],
            ['name' => 'Emma Wilson', 'email' => 'emma@example.com'],
            ['name' => 'Sophia Martinez', 'email' => 'sophia@example.com'],
            ['name' => 'Olivia Chen', 'email' => 'olivia@example.com'],
            ['name' => 'Liam Anderson', 'email' => 'liam@example.com'],
        ];

        foreach ($customers as $customer) {
            User::create([
                'name' => $customer['name'],
                'email' => $customer['email'],
                'password' => Hash::make('password'),
                'role' => 'user',
                'phone' => '+1 (555) '.rand(200, 999).'-'.rand(1000, 9999),
                'is_active' => true,
                'email_verified_at' => now(),
            ]);
        }
    }

    private function seedCategories(): array
    {
        $definitions = [
            ['name' => 'Face Care', 'description' => 'Premium facial care products for radiant skin', 'children' => ['Cleansers', 'Toners', 'Face Masks']],
            ['name' => 'Body Care', 'description' => 'Natural body care essentials for silky smooth skin', 'children' => ['Body Lotions', 'Body Scrubs']],
            ['name' => 'Hair Care', 'description' => 'Healthy hair solutions with botanical extracts', 'children' => ['Shampoos', 'Conditioners']],
            ['name' => 'Skincare', 'description' => 'Complete skincare range for every skin type'],
            ['name' => 'Moisturizers', 'description' => 'Hydrating moisturizers for day and night'],
            ['name' => 'Serums', 'description' => 'Powerful serums targeting specific skin concerns'],
        ];

        $categories = [];

        foreach ($definitions as $index => $definition) {
            $slug = Str::slug($definition['name']);
            $imagePath = $this->images->generate(
                "categories/{$slug}.jpg",
                600,
                600,
                $definition['name'],
                $index
            );

            $category = Category::create([
                'name' => $definition['name'],
                'slug' => $slug,
                'description' => $definition['description'],
                'image' => $imagePath,
                'order' => $index,
                'is_active' => true,
                'meta_title' => $definition['name'].' - Green Beauty',
                'meta_description' => $definition['description'],
                'meta_keywords' => Str::lower($definition['name']).', natural cosmetics, organic beauty',
            ]);

            $categories[$definition['name']] = $category;

            foreach ($definition['children'] ?? [] as $childIndex => $childName) {
                $childSlug = Str::slug($childName);
                $childImage = $this->images->generate(
                    "categories/{$childSlug}.jpg",
                    600,
                    600,
                    $childName,
                    $index + $childIndex + 1
                );

                $child = Category::create([
                    'name' => $childName,
                    'slug' => $childSlug,
                    'description' => "Shop our {$childName} collection",
                    'image' => $childImage,
                    'parent_id' => $category->id,
                    'order' => $childIndex,
                    'is_active' => true,
                    'meta_title' => $childName.' - Green Beauty',
                    'meta_description' => "Discover premium {$childName} made with natural ingredients.",
                ]);

                $categories[$childName] = $child;
            }
        }

        return $categories;
    }

    private function seedTags(): array
    {
        $tagNames = [
            'Organic', 'Vegan', 'Cruelty-Free', 'Natural', 'Paraben-Free',
            'Sulfate-Free', 'Anti-Aging', 'Hydrating', 'Brightening', 'Sensitive Skin',
        ];

        $tags = [];
        foreach ($tagNames as $tagName) {
            $tags[$tagName] = Tag::create([
                'name' => $tagName,
                'slug' => Str::slug($tagName),
            ]);
        }

        return $tags;
    }

    private function seedProducts(array $categories, array $tags): array
    {
        $productsData = [
            [
                'name' => 'Organic Rose Face Cream',
                'category' => 'Face Care',
                'price' => 45.99,
                'sale_price' => 39.99,
                'stock' => 50,
                'short_description' => 'Luxurious rose-infused face cream for all skin types',
                'description' => 'Our premium organic rose face cream is formulated with pure rose essential oils and natural ingredients to deeply nourish and hydrate your skin.',
                'ingredients' => 'Rose Extract, Aloe Vera, Vitamin E, Jojoba Oil, Shea Butter',
                'benefits' => 'Deeply moisturizes, Reduces fine lines, Brightens skin tone',
                'usage_guide' => 'Apply to clean face morning and night.',
                'flags' => ['is_featured' => true, 'is_new' => true],
                'variants' => [
                    ['name' => '30ml', 'type' => 'size', 'price_modifier' => 0, 'stock' => 30],
                    ['name' => '50ml', 'type' => 'size', 'price_modifier' => 8, 'stock' => 20],
                ],
            ],
            [
                'name' => 'Natural Vitamin C Serum',
                'category' => 'Serums',
                'price' => 35.99,
                'stock' => 75,
                'short_description' => 'Powerful anti-aging vitamin C serum',
                'description' => 'Combat signs of aging with our potent vitamin C serum formulated to brighten, firm, and protect your skin.',
                'ingredients' => 'Vitamin C, Hyaluronic Acid, Ferulic Acid, Vitamin E',
                'benefits' => 'Brightens complexion, Reduces dark spots, Firms skin',
                'flags' => ['is_featured' => true, 'is_bestseller' => true],
            ],
            [
                'name' => 'Hydrating Body Lotion',
                'category' => 'Body Care',
                'price' => 28.99,
                'stock' => 100,
                'short_description' => 'Ultra-hydrating body lotion with natural oils',
                'description' => 'Keep your skin soft and supple with our rich body lotion enriched with coconut oil and shea butter.',
                'flags' => ['is_new' => true],
            ],
            [
                'name' => 'Nourishing Hair Mask',
                'category' => 'Hair Care',
                'price' => 32.99,
                'sale_price' => 27.99,
                'stock' => 60,
                'short_description' => 'Deep conditioning hair mask with argan oil',
                'description' => 'Restore damaged hair with our intensive nourishing hair mask made with argan oil and keratin.',
                'flags' => ['is_featured' => true],
            ],
            [
                'name' => 'Green Tea Face Cleanser',
                'category' => 'Cleansers',
                'price' => 24.99,
                'stock' => 120,
                'short_description' => 'Gentle green tea facial cleanser',
                'description' => 'Cleanse and refresh your skin with our antioxidant-rich green tea cleanser.',
            ],
            [
                'name' => 'Aloe Vera Moisturizer',
                'category' => 'Moisturizers',
                'price' => 29.99,
                'stock' => 80,
                'short_description' => 'Soothing aloe vera moisturizer',
                'description' => 'Calm and hydrate your skin with pure aloe vera gel and natural moisturizers.',
                'flags' => ['is_bestseller' => true],
            ],
            [
                'name' => 'Lavender Night Cream',
                'category' => 'Moisturizers',
                'price' => 42.99,
                'stock' => 45,
                'short_description' => 'Relaxing lavender night cream for overnight repair',
                'description' => 'Wake up to refreshed skin with our calming lavender-infused night cream.',
                'flags' => ['is_new' => true, 'is_featured' => true],
            ],
            [
                'name' => 'Rosehip Brightening Serum',
                'category' => 'Serums',
                'price' => 38.99,
                'sale_price' => 34.99,
                'stock' => 55,
                'short_description' => 'Rosehip oil serum for even skin tone',
                'description' => 'Fade dark spots and even skin tone with cold-pressed rosehip oil.',
            ],
            [
                'name' => 'Coconut Body Scrub',
                'category' => 'Body Scrubs',
                'price' => 26.99,
                'stock' => 70,
                'short_description' => 'Exfoliating coconut sugar body scrub',
                'description' => 'Gently exfoliate and nourish with our coconut and brown sugar body scrub.',
                'flags' => ['is_new' => true],
            ],
            [
                'name' => 'Argan Oil Shampoo',
                'category' => 'Shampoos',
                'price' => 22.99,
                'stock' => 90,
                'short_description' => 'Sulfate-free argan oil shampoo',
                'description' => 'Cleanse hair gently while restoring shine with Moroccan argan oil.',
            ],
            [
                'name' => 'Hyaluronic Acid Toner',
                'category' => 'Toners',
                'price' => 19.99,
                'stock' => 110,
                'short_description' => 'Hydrating toner with hyaluronic acid',
                'description' => 'Prep your skin with a burst of hydration from our lightweight toner.',
            ],
            [
                'name' => 'Charcoal Detox Face Mask',
                'category' => 'Face Masks',
                'price' => 31.99,
                'stock' => 65,
                'short_description' => 'Purifying charcoal clay face mask',
                'description' => 'Draw out impurities and minimize pores with activated charcoal and kaolin clay.',
                'flags' => ['is_bestseller' => true],
            ],
        ];

        $products = [];
        $tagCollection = collect($tags);

        foreach ($productsData as $index => $data) {
            $slug = Str::slug($data['name']);
            $featuredImage = $this->images->generate(
                "products/{$slug}.jpg",
                800,
                800,
                $data['name'],
                $index
            );

            $category = $categories[$data['category']] ?? Category::first();

            $product = Product::create([
                'name' => $data['name'],
                'slug' => $slug,
                'sku' => 'GB-'.str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT),
                'category_id' => $category->id,
                'price' => $data['price'],
                'sale_price' => $data['sale_price'] ?? null,
                'stock' => $data['stock'],
                'short_description' => $data['short_description'],
                'description' => $data['description'],
                'ingredients' => $data['ingredients'] ?? null,
                'benefits' => $data['benefits'] ?? null,
                'usage_guide' => $data['usage_guide'] ?? 'Apply as directed on packaging.',
                'featured_image' => $featuredImage,
                'is_featured' => $data['flags']['is_featured'] ?? false,
                'is_new' => $data['flags']['is_new'] ?? false,
                'is_bestseller' => $data['flags']['is_bestseller'] ?? false,
                'is_active' => true,
                'views' => rand(50, 500),
                'rating' => rand(40, 50) / 10,
                'reviews_count' => rand(5, 40),
                'meta_title' => $data['name'].' - Green Beauty',
                'meta_description' => $data['short_description'],
                'meta_keywords' => 'natural cosmetics, '.$slug.', organic skincare',
            ]);

            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $featuredImage,
                'order' => 0,
                'is_primary' => true,
            ]);

            for ($g = 1; $g <= 2; $g++) {
                $galleryPath = $this->images->generate(
                    "products/{$slug}-gallery-{$g}.jpg",
                    800,
                    800,
                    $data['name'].' '.$g,
                    $index + $g
                );

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $galleryPath,
                    'order' => $g,
                    'is_primary' => false,
                ]);
            }

            foreach ($data['variants'] ?? [] as $variant) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'name' => $variant['name'],
                    'type' => $variant['type'],
                    'price_modifier' => $variant['price_modifier'],
                    'sku' => $product->sku.'-'.Str::upper(Str::slug($variant['name'], '')),
                    'stock' => $variant['stock'],
                    'is_active' => true,
                ]);
            }

            $product->tags()->attach(
                $tagCollection->random(rand(2, 4))->pluck('id')
            );

            $products[] = $product;
        }

        return $products;
    }

    private function seedReviews(array $products): void
    {
        $reviewers = [
            ['name' => 'Sarah Johnson', 'email' => 'sarah.j@email.com', 'rating' => 5, 'comment' => 'Absolutely love this product! My skin feels amazing.'],
            ['name' => 'Emily Davis', 'email' => 'emily.d@email.com', 'rating' => 5, 'comment' => 'Best natural product I have ever used. Will buy again!'],
            ['name' => 'Michael Brown', 'email' => 'mike.b@email.com', 'rating' => 4, 'comment' => 'Great quality and fast shipping. Highly recommend.'],
            ['name' => 'Jessica Lee', 'email' => 'jessica.l@email.com', 'rating' => 5, 'comment' => 'Gentle on my sensitive skin. No irritation at all.'],
            ['name' => 'David Kim', 'email' => 'david.k@email.com', 'rating' => 4, 'comment' => 'Nice texture and lovely natural scent.'],
            ['name' => 'Anna Taylor', 'email' => 'anna.t@email.com', 'rating' => 5, 'comment' => 'Visible results within two weeks. Impressed!'],
            ['name' => 'Rachel Green', 'email' => 'rachel.g@email.com', 'rating' => 4, 'comment' => 'Good value for money. Packaging is beautiful too.'],
            ['name' => 'Chris Martin', 'email' => 'chris.m@email.com', 'rating' => 5, 'comment' => 'My wife loves it. Ordering more for gifts.'],
        ];

        $users = User::where('role', 'user')->pluck('id');

        foreach ($products as $product) {
            $selected = collect($reviewers)->random(rand(2, 4));

            foreach ($selected as $review) {
                Review::create([
                    'product_id' => $product->id,
                    'user_id' => $users->random(),
                    'name' => $review['name'],
                    'email' => $review['email'],
                    'rating' => $review['rating'],
                    'comment' => $review['comment'],
                    'is_approved' => true,
                ]);
            }

            $product->updateRating();
        }
    }

    private function seedBanners(): void
    {
        $banners = [
            [
                'title' => 'Welcome to Natural Beauty',
                'subtitle' => 'Discover our range of organic cosmetic products',
                'file' => 'banners/banner1.jpg',
                'label' => 'Natural Beauty',
                'button_text' => 'Shop Now',
                'link' => '/products',
                'order' => 1,
            ],
            [
                'title' => 'Summer Sale - 30% Off',
                'subtitle' => 'Limited time offer on selected skincare essentials',
                'file' => 'banners/banner2.jpg',
                'label' => 'Summer Sale',
                'button_text' => 'View Deals',
                'link' => '/products',
                'order' => 2,
            ],
            [
                'title' => 'New Arrivals Collection',
                'subtitle' => 'Fresh botanical formulas for glowing skin',
                'file' => 'banners/banner3.jpg',
                'label' => 'New Arrivals',
                'button_text' => 'Explore',
                'link' => '/products',
                'order' => 3,
            ],
        ];

        foreach ($banners as $index => $banner) {
            $image = $this->images->generate($banner['file'], 1920, 600, $banner['label'], $index);

            Banner::create([
                'title' => $banner['title'],
                'subtitle' => $banner['subtitle'],
                'image' => $image,
                'button_text' => $banner['button_text'],
                'link' => $banner['link'],
                'position' => 'home_slider',
                'order' => $banner['order'],
                'is_active' => true,
            ]);
        }
    }

    private function seedTestimonials(): void
    {
        $testimonials = [
            ['name' => 'Sarah Johnson', 'position' => 'Beauty Blogger', 'company' => 'Glow Diary', 'rating' => 5],
            ['name' => 'Emily Davis', 'position' => 'Verified Customer', 'company' => null, 'rating' => 5],
            ['name' => 'Michael Brown', 'position' => 'Skincare Enthusiast', 'company' => null, 'rating' => 4],
            ['name' => 'Priya Sharma', 'position' => 'Dermatology Student', 'company' => 'NYU', 'rating' => 5],
            ['name' => 'Lisa Thompson', 'position' => 'Makeup Artist', 'company' => 'Studio Luxe', 'rating' => 5],
            ['name' => 'James Wilson', 'position' => 'Verified Customer', 'company' => null, 'rating' => 4],
        ];

        $quotes = [
            'These products are absolutely amazing! My skin has never looked better.',
            'I have been using Green Beauty for 3 months and the results are incredible.',
            'Great products with excellent customer service. Will definitely order again!',
            'Finally found cosmetics that work for my sensitive skin without irritation.',
            'The natural ingredients make all the difference. Highly recommend to everyone.',
            'Beautiful packaging, lovely scents, and products that actually deliver results.',
        ];

        foreach ($testimonials as $index => $testimonial) {
            $image = $this->images->generate(
                'testimonials/avatar-'.($index + 1).'.jpg',
                300,
                300,
                $testimonial['name'],
                $index
            );

            Testimonial::create([
                'name' => $testimonial['name'],
                'position' => $testimonial['position'],
                'company' => $testimonial['company'],
                'testimonial' => $quotes[$index],
                'image' => $image,
                'rating' => $testimonial['rating'],
                'order' => $index,
                'is_active' => true,
            ]);
        }
    }

    private function seedBlogs(): void
    {
        $posts = [
            [
                'title' => '10 Benefits of Natural Skincare',
                'excerpt' => 'Discover why natural skincare products are better for your skin and the environment.',
                'content' => 'Natural skincare has gained immense popularity in recent years. Using products made from organic ingredients can significantly improve your skin health while reducing exposure to harsh chemicals.',
            ],
            [
                'title' => 'How to Build a Morning Skincare Routine',
                'excerpt' => 'A simple step-by-step guide to start your day with glowing skin.',
                'content' => 'A consistent morning routine sets the tone for healthy skin all day. Start with a gentle cleanser, follow with toner and serum, then lock in moisture with SPF protection.',
            ],
            [
                'title' => 'The Power of Vitamin C for Your Skin',
                'excerpt' => 'Learn how vitamin C serums brighten, protect, and rejuvenate your complexion.',
                'content' => 'Vitamin C is one of the most researched skincare ingredients. It helps fade dark spots, boosts collagen production, and shields skin from environmental damage.',
            ],
            [
                'title' => '5 Organic Ingredients to Look For',
                'excerpt' => 'Know which natural ingredients deliver real results in your beauty products.',
                'content' => 'From aloe vera to rosehip oil, certain botanical ingredients have stood the test of time. Here are five must-have ingredients for any natural beauty regimen.',
            ],
            [
                'title' => 'Sustainable Beauty: Our Commitment',
                'excerpt' => 'How Green Beauty is reducing waste and sourcing responsibly.',
                'content' => 'Sustainability is at the heart of everything we do. From recyclable packaging to ethically sourced ingredients, we are committed to beauty that cares for the planet.',
            ],
        ];

        foreach ($posts as $index => $post) {
            $slug = Str::slug($post['title']);
            $image = $this->images->generate(
                "blogs/{$slug}.jpg",
                1200,
                630,
                $post['title'],
                $index
            );

            Blog::create([
                'title' => $post['title'],
                'slug' => $slug,
                'excerpt' => $post['excerpt'],
                'content' => $post['content'],
                'featured_image' => $image,
                'author_id' => 1,
                'views' => rand(100, 800),
                'is_published' => true,
                'published_at' => now()->subDays(rand(1, 60)),
                'meta_title' => $post['title'].' - Green Beauty Blog',
                'meta_description' => $post['excerpt'],
            ]);
        }
    }

    private function seedFaqs(): void
    {
        $faqs = [
            ['question' => 'Are your products organic?', 'answer' => 'Yes, all our products are made with certified organic ingredients sourced from sustainable farms.', 'category' => 'Products'],
            ['question' => 'Do you test on animals?', 'answer' => 'No, we are proud to be cruelty-free. We never test our products on animals.', 'category' => 'Ethics'],
            ['question' => 'What is your return policy?', 'answer' => 'We offer a 30-day money-back guarantee on all products. If you are not satisfied, we will refund your purchase.', 'category' => 'Orders'],
            ['question' => 'How long does shipping take?', 'answer' => 'Standard shipping takes 3-5 business days. Express shipping is available for 1-2 day delivery.', 'category' => 'Shipping'],
            ['question' => 'Are products safe for sensitive skin?', 'answer' => 'Most of our products are formulated for sensitive skin. Check individual product pages for allergen information.', 'category' => 'Products'],
            ['question' => 'Do you ship internationally?', 'answer' => 'Yes, we ship to over 40 countries worldwide. Shipping costs are calculated at checkout.', 'category' => 'Shipping'],
            ['question' => 'How should I store my products?', 'answer' => 'Store in a cool, dry place away from direct sunlight. Refrigeration is recommended for some serums.', 'category' => 'Products'],
            ['question' => 'Can I use a discount code with sale items?', 'answer' => 'Discount codes cannot be combined with sale prices unless stated otherwise in the promotion.', 'category' => 'Orders'],
        ];

        foreach ($faqs as $index => $faq) {
            Faq::create([
                'question' => $faq['question'],
                'answer' => $faq['answer'],
                'category' => $faq['category'],
                'order' => $index,
                'is_active' => true,
            ]);
        }
    }

    private function seedCmsPages(): void
    {
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'content' => 'Welcome to Green Beauty, your destination for premium natural cosmetics. Founded in 2018, we are dedicated to providing high-quality, organic beauty products that are good for you and the environment. Our mission is to help you achieve healthy, beautiful skin using only the finest natural ingredients sourced from sustainable farms around the world.',
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => 'Your privacy is important to us. This privacy policy explains how we collect, use, and protect your personal information when you visit our website or make a purchase.',
            ],
            [
                'title' => 'Terms & Conditions',
                'slug' => 'terms-conditions',
                'content' => 'By using our website, you agree to these terms and conditions. Please read them carefully before placing an order.',
            ],
            [
                'title' => 'Shipping & Returns',
                'slug' => 'shipping-returns',
                'content' => 'We offer free standard shipping on orders over $50. Returns are accepted within 30 days of delivery for a full refund on unused products.',
            ],
        ];

        foreach ($pages as $page) {
            CmsPage::create([
                'title' => $page['title'],
                'slug' => $page['slug'],
                'content' => $page['content'],
                'template' => 'default',
                'is_active' => true,
            ]);
        }
    }

    private function seedSiteSettings(): void
    {
        $logo = $this->images->generateLogo('settings/site-logo.png', 'Green Beauty');
        $favicon = $this->images->generateFavicon('settings/site-favicon.png');

        $settings = [
            ['key' => 'site_name', 'value' => 'Green Beauty', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Natural Cosmetics for Everyone', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Premium natural and organic cosmetic products crafted with love. Shop skincare, haircare, and body care essentials.', 'type' => 'textarea', 'group' => 'general'],
            ['key' => 'site_logo', 'value' => $logo, 'type' => 'image', 'group' => 'general'],
            ['key' => 'site_favicon', 'value' => $favicon, 'type' => 'image', 'group' => 'general'],
            ['key' => 'footer_about', 'value' => 'We provide premium natural cosmetic products crafted with love and care. Every formula is vegan, cruelty-free, and made with sustainably sourced ingredients.', 'type' => 'textarea', 'group' => 'general'],
            ['key' => 'contact_email', 'value' => 'info@greenbeauty.com', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '+1 (555) 123-4567', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => "123 Beauty Street\nNew York, NY 10001\nUnited States", 'type' => 'textarea', 'group' => 'contact'],
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/greenbeauty', 'type' => 'text', 'group' => 'social'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/greenbeauty', 'type' => 'text', 'group' => 'social'],
            ['key' => 'twitter_url', 'value' => 'https://twitter.com/greenbeauty', 'type' => 'text', 'group' => 'social'],
            ['key' => 'pinterest_url', 'value' => 'https://pinterest.com/greenbeauty', 'type' => 'text', 'group' => 'social'],
            ['key' => 'meta_title', 'value' => 'Green Beauty - Natural Organic Cosmetics', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'meta_description', 'value' => 'Shop premium natural skincare, haircare, and body care products. Organic, vegan, and cruelty-free beauty essentials.', 'type' => 'textarea', 'group' => 'seo'],
            ['key' => 'meta_keywords', 'value' => 'natural cosmetics, organic skincare, vegan beauty, cruelty-free, green beauty, face cream, serum', 'type' => 'text', 'group' => 'seo'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::create($setting);
        }
    }

    private function seedHomepageSections(): void
    {
        $aboutImage = $this->images->generate('homepage/about-section.jpg', 1200, 800, 'About Green Beauty', 0);
        $promoImage = $this->images->generate('homepage/promo-section.jpg', 1200, 600, 'Shop Natural', 1);

        $sections = [
            [
                'section_name' => 'about',
                'title' => 'Natural Beauty, Naturally Made',
                'subtitle' => 'Discover the power of nature',
                'content' => 'We believe in the power of natural ingredients. All our products are carefully crafted using organic, sustainable ingredients that are gentle on your skin and kind to the environment.',
                'image' => $aboutImage,
                'button_text' => 'Learn More',
                'button_link' => '/about',
                'order' => 1,
            ],
            [
                'section_name' => 'promo',
                'title' => 'Clean Beauty You Can Trust',
                'subtitle' => 'No parabens, no sulfates, no compromise',
                'content' => 'Every product in our collection is dermatologist-tested, ethically sourced, and packaged in recyclable materials.',
                'image' => $promoImage,
                'button_text' => 'Shop Collection',
                'button_link' => '/products',
                'order' => 2,
            ],
        ];

        foreach ($sections as $section) {
            HomepageSection::create(array_merge($section, ['is_active' => true]));
        }
    }

    private function seedNewsletters(): void
    {
        $emails = [
            'subscriber1@email.com',
            'subscriber2@email.com',
            'beautyfan@email.com',
            'skincarelover@email.com',
            'newsletter@email.com',
        ];

        foreach ($emails as $email) {
            Newsletter::create([
                'email' => $email,
                'is_subscribed' => true,
                'subscribed_at' => now()->subDays(rand(1, 90)),
            ]);
        }
    }

    private function seedContactInquiries(): void
    {
        $inquiries = [
            ['name' => 'Alice Cooper', 'email' => 'alice@email.com', 'subject' => 'Product Question', 'message' => 'Is the Rose Face Cream suitable for oily skin?', 'status' => 'new'],
            ['name' => 'Bob Harris', 'email' => 'bob@email.com', 'subject' => 'Wholesale Inquiry', 'message' => 'I am interested in wholesale pricing for my spa.', 'status' => 'read'],
            ['name' => 'Carol White', 'email' => 'carol@email.com', 'subject' => 'Order Status', 'message' => 'Can you provide an update on order #12345?', 'status' => 'replied'],
            ['name' => 'Daniel Park', 'email' => 'daniel@email.com', 'subject' => 'Ingredient List', 'message' => 'Please send the full ingredient list for the Vitamin C Serum.', 'status' => 'new'],
            ['name' => 'Eva Rodriguez', 'email' => 'eva@email.com', 'subject' => 'Partnership', 'message' => 'We would love to feature your products in our boutique.', 'status' => 'read'],
        ];

        foreach ($inquiries as $inquiry) {
            ContactInquiry::create([
                'name' => $inquiry['name'],
                'email' => $inquiry['email'],
                'phone' => '+1 (555) '.rand(200, 999).'-'.rand(1000, 9999),
                'subject' => $inquiry['subject'],
                'message' => $inquiry['message'],
                'status' => $inquiry['status'],
            ]);
        }
    }
}
