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
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class IppeoDataSeeder extends Seeder
{
    private array $downloaded = [];

    public function run(): void
    {
        $this->cleanTables();
        $this->command?->info('Tables cleaned.');

        $this->createAdminUser();
        $this->command?->info('Admin user created.');

        $categories = $this->createCategories();
        $this->command?->info('Categories created.');

        $products = $this->createProducts($categories);
        $this->command?->info('Products created with images.');

        $tags = $this->createTags();
        $this->command?->info('Tags created.');

        $this->attachProductTags($products, $tags);
        $this->command?->info('Product-tag associations created.');

        $this->createReview($products);
        $this->command?->info('Review created.');

        $this->createBanners();
        $this->command?->info('Banners created.');

        $this->createTestimonials();
        $this->command?->info('Testimonials created.');

        $this->createCmsPages();
        $this->command?->info('CMS pages created.');

        $this->createSiteSettings();
        $this->command?->info('Site settings created.');

        $this->createHomepageSections();
        $this->command?->info('Homepage sections created.');

        $this->createFaqs();
        $this->command?->info('FAQs created.');

        $this->command?->info('Ippeo live site data seeded successfully.');
    }

    private function cleanTables(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        ProductVariant::truncate();
        ProductImage::truncate();
        DB::table('product_tag')->truncate();
        Review::truncate();
        Product::truncate();
        Category::truncate();
        Tag::truncate();
        Banner::truncate();
        Testimonial::truncate();
        Blog::truncate();
        Faq::truncate();
        CmsPage::truncate();
        ContactInquiry::truncate();
        Newsletter::truncate();
        HomepageSection::truncate();
        SiteSetting::truncate();
        User::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    private function createAdminUser(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@cosmetic.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+91 74986 86978',
            'address' => 'Ippeo Essentials Products, Sanand, Ahmedabad',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
    }

    private function createCategories(): array
    {
        $beauty = Category::create([
            'name' => 'Beauty',
            'slug' => 'beauty',
            'description' => 'Premium beauty products for radiant skin',
            'image' => null,
            'parent_id' => null,
            'order' => 0,
            'is_active' => true,
            'meta_title' => 'Beauty - Ippeo Essential Products',
            'meta_description' => 'Premium beauty products for radiant skin',
            'meta_keywords' => 'beauty, skincare, cosmetics',
        ]);

        $faceWash = Category::create([
            'name' => 'Face Wash',
            'slug' => 'face-wash',
            'description' => 'Refreshing face washes for clean and glowing skin',
            'image' => 'categories/face-wash.png',
            'parent_id' => $beauty->id,
            'order' => 0,
            'is_active' => true,
            'meta_title' => 'Face Wash - Ippeo Essential Products',
            'meta_description' => 'Refreshing face washes for clean and glowing skin',
            'meta_keywords' => 'face wash, cleanser, skincare',
        ]);

        $faceCream = Category::create([
            'name' => 'Face Cream',
            'slug' => 'face-cream',
            'description' => 'Nourishing face creams for everyday skincare',
            'image' => 'categories/face-cream.png',
            'parent_id' => $beauty->id,
            'order' => 1,
            'is_active' => true,
            'meta_title' => 'Face Cream - Ippeo Essential Products',
            'meta_description' => 'Nourishing face creams for everyday skincare',
            'meta_keywords' => 'face cream, moisturizer, skincare',
        ]);

        $faceMask = Category::create([
            'name' => 'Face Mask',
            'slug' => 'face-mask',
            'description' => 'Deep cleansing face masks for pure skin',
            'image' => 'categories/face-mask.png',
            'parent_id' => $beauty->id,
            'order' => 2,
            'is_active' => true,
            'meta_title' => 'Face Mask - Ippeo Essential Products',
            'meta_description' => 'Deep cleansing face masks for pure skin',
            'meta_keywords' => 'face mask, clay mask, skincare',
        ]);

        Category::create([
            'name' => 'Uncategorized',
            'slug' => 'uncategorized',
            'description' => 'Uncategorized products',
            'image' => null,
            'parent_id' => null,
            'order' => 99,
            'is_active' => true,
            'meta_title' => 'Uncategorized',
            'meta_description' => 'Uncategorized products',
            'meta_keywords' => 'uncategorized',
        ]);

        return [
            'Face Wash' => $faceWash,
            'Face Cream' => $faceCream,
            'Face Mask' => $faceMask,
        ];
    }

    private function downloadImage(string $url, string $productSlug, int $index = 0): ?string
    {
        if (isset($this->downloaded[$url])) {
            return $this->downloaded[$url];
        }

        $extension = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
        if (!$extension) {
            $extension = 'jpg';
        }
        $extension = strtolower($extension);

        $filename = $index === 0
            ? "{$productSlug}.{$extension}"
            : "{$productSlug}-{$index}.{$extension}";

        $path = "products/{$filename}";

        if (Storage::disk('public')->exists($path)) {
            $this->downloaded[$url] = $path;
            return $path;
        }

        try {
            $context = stream_context_create([
                'http' => [
                    'timeout' => 30,
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                ],
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ]);

            $imageData = @file_get_contents($url, false, $context);

            if ($imageData === false) {
                $this->command?->warn("  Failed to download: {$url}");
                return null;
            }

            Storage::disk('public')->put($path, $imageData);
            $this->downloaded[$url] = $path;
            $this->command?->info("  Downloaded: {$path}");

            return $path;
        } catch (\Exception $e) {
            $this->command?->warn("  Error downloading {$url}: " . $e->getMessage());
            return null;
        }
    }

    private function downloadSimpleImage(string $url, string $path): ?string
    {
        if (isset($this->downloaded[$url])) {
            return $this->downloaded[$url];
        }

        if (Storage::disk('public')->exists($path)) {
            $this->downloaded[$url] = $path;
            return $path;
        }

        try {
            $context = stream_context_create([
                'http' => [
                    'timeout' => 30,
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                ],
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ]);

            $imageData = @file_get_contents($url, false, $context);

            if ($imageData === false) {
                return null;
            }

            Storage::disk('public')->put($path, $imageData);
            $this->downloaded[$url] = $path;
            return $path;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function createProducts(array $categories): array
    {
        $products = [];
        $productsData = $this->getProductsData();

        foreach ($productsData as $data) {
            $category = $categories[$data['category']] ?? Category::first();

            $featuredImage = $this->downloadImage($data['featured_image_url'], $data['slug']);

            $product = Product::create([
                'name' => $data['name'],
                'slug' => $data['slug'],
                'sku' => $data['sku'],
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
                'is_featured' => $data['is_featured'] ?? false,
                'is_new' => $data['is_new'] ?? false,
                'is_bestseller' => $data['is_bestseller'] ?? false,
                'is_active' => true,
                'views' => 0,
                'rating' => 0,
                'reviews_count' => 0,
                'meta_title' => $data['name'] . ' - Ippeo Essential Products',
                'meta_description' => strip_tags($data['short_description']),
                'meta_keywords' => 'ippeo, skincare, ' . $data['slug'],
            ]);

            if ($featuredImage) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $featuredImage,
                    'order' => 0,
                    'is_primary' => true,
                ]);
            }

            foreach ($data['gallery'] as $gIndex => $galleryUrl) {
                $galleryPath = $this->downloadImage($galleryUrl, $data['slug'], $gIndex + 1);
                if ($galleryPath) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $galleryPath,
                        'order' => $gIndex + 1,
                        'is_primary' => false,
                    ]);
                }
            }

            $products[] = $product;
        }

        return $products;
    }

    private function getProductsData(): array
    {
        return [
            [
                'name' => 'Ippeo Vitamin C Face Wash',
                'slug' => 'vitamin-c-face-wash',
                'sku' => 'IPP-VCFW-001',
                'category' => 'Face Wash',
                'price' => 269,
                'stock' => 100,
                'short_description' => "VITAMIN C ENRICHED: Formulated with Vitamin C and Orange Extracts to brighten skin, fade pigmentation, and leave it feeling fresh and revitalised.\nDEEP CLEANSING ACTION: Effectively removes dirt, excess oil, and impurities from pores, giving you a thoroughly clean and refreshed complexion with every wash.\nBRIGHTENS AND PURIFIES: Helps reduce dullness and uneven skin tone while gently exfoliating to reveal smoother, softer, and more radiant-looking skin.\nSUITABLE FOR FACE AND BODY: A versatile daily cleanser ideal for both face and body use, suitable for men and women seeking glowing, nourished skin.\n100 GM PACK: Lightweight, refreshing formula that cleanses without over-drying, perfect for incorporating into your everyday skincare routine.",
                'description' => "Ippeo Vitamin C Face Wash is a refreshing gel cleanser crafted to brighten and purify your skin with every wash. Enriched with the goodness of Vitamin C, Orange, and Papaya Extracts, this face wash works to effectively cleanse dirt, excess oil, and environmental impurities from your skin, leaving it feeling soft, fresh, and radiant. Its carefully formulated blend helps brighten the skin, fade pigmentation, boost collagen production, reduce inflammation, and gently exfoliate for a smoother complexion. Suitable for both face and body, this lightweight formula is ideal for daily use and works well for all skin types. The 100 gm pack makes it a convenient addition to your everyday skincare routine. Whether you are looking to achieve a healthy glow or simply maintain clean, nourished skin, this face wash offers a refreshing cleansing experience that supports visibly healthier-looking skin with regular use. Suitable for both men and women seeking a brighter, more even skin tone.",
                'featured_image_url' => 'https://ippeo.in/wp-content/uploads/2016/10/ChatGPT-Image-May-19-2026-11_06_03-PM.png',
                'gallery' => [
                    'https://ippeo.in/wp-content/uploads/2016/10/ChatGPT-Image-May-19-2026-11_08_37-PM.png',
                    'https://ippeo.in/wp-content/uploads/2016/10/WhatsApp-Image-2026-05-13-at-9.02.39-PM.jpeg',
                ],
                'ingredients' => 'Vitamin C, Orange Extract, Papaya Extract, Glycerin, Aloe Vera',
                'benefits' => 'Brightens skin, Fades pigmentation, Deep cleansing, Exfoliates gently',
                'is_featured' => true,
                'is_new' => false,
                'is_bestseller' => true,
            ],
            [
                'name' => 'Ippeo Glow Cream Whitening Cream',
                'slug' => 'ippeo-glow-cream-whitening-cream',
                'sku' => 'IPP-GCWC-002',
                'category' => 'Face Cream',
                'price' => 269,
                'stock' => 75,
                'short_description' => "NATURAL RADIANCE: Helps improve the skin's natural glow and brightens dull-looking skin, giving you a vibrant and healthy appearance\nLIGHTWEIGHT & ABSORBENT: The non-heavy, lightweight texture absorbs quickly into the skin, making it comfortable for both morning and evening use\nSUITABLE FOR ALL SKIN TYPES: A gentle yet effective daily-use cream designed to work beautifully on dry, oily, sensitive, or combination skin\nDAILY PROTECTION & CARE: Provides a smoother skin texture and evening out skin tone with every application\nPOWERFUL BRIGHTENING INGREDIENTS: Formulated with Niacinamide and Alpha Arbutin to reduce the appearance of dark spots, hyperpigmentation, and uneven skin tone\nDEEP HYDRATION & NOURISHMENT: Enriched with Shea Butter, Vitamin E, and Jojoba Oil to deliver long-lasting moisture while promoting a smoother, more vibrant complexion",
                'description' => "Experience the secret to a luminous complexion with Ippeo Glow Cream, a premium whitening and radiance-boosting formula designed for all skin types. This nourishing brightening cream is expertly crafted to enhance your skin's natural radiance while leaving it incredibly soft, smooth, and deeply hydrated. The advanced formula features a powerful blend of Niacinamide (Vitamin B3) and Alpha Arbutin, two powerhouse ingredients known for reducing the appearance of dark spots, hyperpigmentation, and uneven skin tone. Enriched with skin-loving ingredients like Shea Butter, Vitamin E, and Jojoba Oil, this cream delivers deep hydration while promoting a smoother, more vibrant complexion. Whether you're looking to brighten dull skin or maintain a consistent glow, Ippeo provides lightweight, long-lasting moisture that fits perfectly into your daily skincare routine",
                'featured_image_url' => 'https://ippeo.in/wp-content/uploads/2026/05/WhatsApp-Image-2026-05-16-at-8.51.26-PM.jpeg',
                'gallery' => [
                    'https://ippeo.in/wp-content/uploads/2026/05/WhatsApp-Image-2026-05-16-at-8.51.44-PM.jpeg',
                    'https://ippeo.in/wp-content/uploads/2026/05/WhatsApp-Image-2026-05-16-at-8.51.37-PM.jpeg',
                    'https://ippeo.in/wp-content/uploads/2026/05/WhatsApp-Image-2026-05-16-at-8.51.56-PM.jpeg',
                    'https://ippeo.in/wp-content/uploads/2026/05/WhatsApp-Image-2026-05-16-at-8.51.54-PM.jpeg',
                ],
                'ingredients' => 'Niacinamide, Alpha Arbutin, Shea Butter, Vitamin E, Jojoba Oil',
                'benefits' => 'Brightens skin, Reduces dark spots, Deep hydration, Evens skin tone',
                'is_featured' => true,
                'is_new' => true,
                'is_bestseller' => true,
            ],
            [
                'name' => 'Ippeo Sunscreen Darkness Protectant SPF 50 PA+++ for Face & Body',
                'slug' => 'ippeo_sunscreen_darkness_protectant',
                'sku' => 'IPP-SSDP-003',
                'category' => 'Face Cream',
                'price' => 279,
                'stock' => 60,
                'short_description' => "Broad Spectrum SPF 50 Protection: Protects your skin from harmful UVA & UVB rays that cause tanning, sunburn, and premature aging\nTinted Formula - No White Cast: Specially designed for Indian skin tones. Blends easily and leaves no chalky or white residue\n100% Mineral-Based & Skin Friendly: Gentle formula with mineral filters, suitable for sensitive skin and daily use\nWater Resistant (Up to 80 Minutes): Suitable for outdoor activities, travel, and humid conditions\nSuitable for Face & Body: Lightweight texture that works well under makeup or on bare skin for everyday protection\nPrevents Premature Aging: Helps shield skin from sun damage that leads to fine lines, wrinkles, and dark spots over time",
                'description' => "Ippeo Sunscreen SPF 50 is a high-performance mineral sunscreen designed to protect and enhance your skin naturally. Formulated with broad-spectrum UVA & UVB protection, it helps prevent sun damage, tanning, and early signs of aging. Its tinted, no-white-cast formula blends seamlessly into medium to dark skin tones, making it ideal for daily use. The lightweight, non-greasy texture ensures comfortable wear throughout the day, whether you're indoors or outdoors. With water-resistant protection up to 80 minutes, this sunscreen is perfect for Indian weather conditions. Safe, gentle, and effective - your everyday shield against sun damage.",
                'featured_image_url' => 'https://ippeo.in/wp-content/uploads/2026/05/SPF-50-Sunscreen.png',
                'gallery' => [
                    'https://ippeo.in/wp-content/uploads/2026/05/SPF-50-Sunscreen-3.png',
                    'https://ippeo.in/wp-content/uploads/2026/05/SPF-50-Sunscreen-4.png',
                    'https://ippeo.in/wp-content/uploads/2026/05/SPF-50-Sunscreen-5.png',
                ],
                'ingredients' => 'Zinc Oxide, Titanium Dioxide, Vitamin E, Aloe Vera',
                'benefits' => 'SPF 50 protection, No white cast, Water resistant, Prevents aging',
                'is_featured' => true,
                'is_new' => false,
                'is_bestseller' => false,
            ],
            [
                'name' => 'Ippeo Glow Cream Darkness Elimination Cream',
                'slug' => 'ippeo_glow_cream_darkness_elimination_cream',
                'sku' => 'IPP-GCDC-004',
                'category' => 'Face Cream',
                'price' => 279,
                'stock' => 50,
                'short_description' => "Glow & Brightening: Enhances natural radiance for a healthy, glowing look\nReduces Dark Spots: Helps minimize appearance of pigmentation & uneven skin tone\nEven Tone Formula: Promotes smoother and more balanced complexion\nDeep Moisturization: Keeps skin soft, hydrated & nourished all day\nPollution Defense: Helps protect skin from daily environmental damage\nLightweight Texture: Non-greasy formula absorbs quickly into the skin, leaving a soft, silky finish without any sticky feel",
                'description' => "Ippeo Glow Cream - Darkness Elimination Cream is specially formulated to give your skin a brighter, smoother, and more even-toned appearance. Its advanced brightening formula helps reduce the appearance of dark spots, dullness, and uneven skin tone, revealing naturally radiant skin. Enriched with skin-loving ingredients, this cream provides deep hydration while protecting your skin from pollution and daily environmental stress. The lightweight, non-greasy texture absorbs quickly into the skin, leaving a soft, silky finish without any sticky feel. Perfect for daily use, Ippeo Glow Cream works to restore your skin's natural glow while keeping it moisturized, healthy, and refreshed. Suitable for all skin types, it fits easily into your everyday skincare routine.",
                'featured_image_url' => 'https://ippeo.in/wp-content/uploads/2026/06/Glow-cream-darkness-Elimination-cream-2.jpg',
                'gallery' => [
                    'https://ippeo.in/wp-content/uploads/2026/06/Glow-cream-darkness-Elimination-cream-3.jpg',
                    'https://ippeo.in/wp-content/uploads/2026/06/Glow-cream-darkness-Elimination-cream.jpg',
                ],
                'ingredients' => 'Niacinamide, Vitamin C, Shea Butter, Jojoba Oil, Green Tea Extract',
                'benefits' => 'Dark spot reduction, Brightening, Deep moisturization, Pollution defense',
                'is_featured' => true,
                'is_new' => true,
                'is_bestseller' => false,
            ],
            [
                'name' => 'Ippeo Anti-Pollution Face Mask',
                'slug' => 'ippeo-anti-pollution-face-mask',
                'sku' => 'IPP-APFM-005',
                'category' => 'Face Mask',
                'price' => 279,
                'stock' => 80,
                'short_description' => "ANTI-POLLUTION PROTECTION: Ippeo's Special Edition face mask creates a protective barrier against environmental pollutants, dirt, and impurities for cleaner, healthier-looking skin\nDEEP CLEANSING CLAY FORMULA: Enriched with a powerful clay base that draws out excess oil, unclogs pores, and removes deep-seated impurities for a thorough cleanse\nNIACINAMIDE & GREEN TEA: Formulated with skin-brightening Niacinamide and antioxidant-rich Green Tea extract to help even skin tone and combat free radical damage\nOIL CONTROL: Effectively regulates sebum production, leaving your skin feeling fresh, matte, and balanced without stripping away natural moisture\nSUITABLE FOR ALL SKIN TYPES: This 100g pump-bottle face mask is gentle yet effective, making it appropriate for oily, dry, combination, and sensitive skin\nCONVENIENT PUMP DISPENSER: Features a hygienic pump-bottle design that ensures mess-free and controlled application for easy integration into your skincare routine",
                'description' => "Introducing the Ippeo Anti-Pollution Face Mask - Special Edition, a powerful deep cleansing solution crafted to combat the daily effects of pollution and environmental stressors on your skin. This 100g clay-based formula is enriched with Niacinamide and Green Tea, working together to purify pores, control excess oil, and leave your skin feeling refreshed and revitalised. The convenient pump-dispenser bottle ensures hygienic and mess-free application every time. Suitable for all skin types, this face mask gently draws out impurities, unclogs pores, and helps restore a natural, healthy glow. Niacinamide helps even out skin tone and minimise the appearance of pores, while Green Tea provides soothing antioxidant benefits. Whether you have oily, dry, combination, or sensitive skin, this mask adapts to your skin's needs. Incorporate it into your weekly skincare routine for visibly cleaner, smoother, and more radiant skin.",
                'featured_image_url' => 'https://ippeo.in/wp-content/uploads/2026/06/anti-pollution-mask1.png',
                'gallery' => [
                    'https://ippeo.in/wp-content/uploads/2026/06/anti-pollution-mask2.png',
                    'https://ippeo.in/wp-content/uploads/2026/06/anti-pollution-mask3.png',
                    'https://ippeo.in/wp-content/uploads/2026/06/anti-pollution-mask.png',
                ],
                'ingredients' => 'Kaolin Clay, Niacinamide, Green Tea Extract, Aloe Vera, Vitamin E',
                'benefits' => 'Anti-pollution protection, Deep cleansing, Oil control, Pore minimization',
                'is_featured' => true,
                'is_new' => true,
                'is_bestseller' => false,
            ],
            [
                'name' => 'Ippeo Sunscreen Glow Cream',
                'slug' => 'ippeo-sunscreen-glow-cream',
                'sku' => 'IPP-SSGC-006',
                'category' => 'Face Cream',
                'price' => 279,
                'stock' => 65,
                'short_description' => "Cooling Sunscreen Protection: Lightweight sunscreen with a cooling effect for comfortable daily wear\nGlow-Enhancing Formula: Infused with skin-brightening ingredients that leave a natural, healthy glow\nBroad Spectrum SPF: Protects against harmful UVA & UVB rays to prevent tanning and sun damage\nNon-Greasy Texture: Quick-absorbing, lightweight formula that doesn't leave a sticky residue\nSuitable for Daily Use: Perfect under makeup or on bare skin for everyday sun protection",
                'description' => "Ippeo Sunscreen Glow Cream is a multi-benefit skincare product that combines effective sun protection with a radiant glow-enhancing formulation. Designed for daily use, this lightweight and cooling sunscreen cream protects your skin from harmful UVA and UVB rays while imparting a natural, healthy luminosity. The non-greasy, quick-absorbing texture makes it comfortable to wear under makeup or on its own, suitable for all skin types. With its unique blend of sun filters and skin-nourishing ingredients, it helps prevent tanning, premature aging, and sun damage while keeping your skin hydrated and glowing throughout the day.",
                'featured_image_url' => 'https://ippeo.in/wp-content/uploads/2026/06/cooling-sunscreen1.png',
                'gallery' => [
                    'https://ippeo.in/wp-content/uploads/2026/06/cooling-sunscreen3.png',
                    'https://ippeo.in/wp-content/uploads/2026/06/cooling-sunscreen2.png',
                ],
                'ingredients' => 'Zinc Oxide, Niacinamide, Vitamin E, Aloe Vera, Jojoba Oil',
                'benefits' => 'Sun protection, Glow enhancement, Cooling effect, Non-greasy',
                'is_featured' => true,
                'is_new' => true,
                'is_bestseller' => false,
            ],
        ];
    }

    private function createTags(): array
    {
        $tagNames = [
            'Vitamin C', 'Niacinamide', 'SPF 50', 'Brightening',
            'Anti-Pollution', 'Sunscreen', 'Glow', 'Face Wash',
            'Face Cream', 'Face Mask', 'Whitening', 'Darkness Elimination',
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

    private function attachProductTags(array $products, array $tags): void
    {
        $associations = [
            0 => ['Vitamin C', 'Face Wash', 'Brightening', 'Glow'],
            1 => ['Niacinamide', 'Brightening', 'Face Cream', 'Glow', 'Whitening'],
            2 => ['SPF 50', 'Sunscreen', 'Face Cream', 'Brightening'],
            3 => ['Brightening', 'Glow', 'Darkness Elimination', 'Face Cream'],
            4 => ['Anti-Pollution', 'Face Mask', 'Niacinamide', 'Glow'],
            5 => ['Sunscreen', 'SPF 50', 'Glow', 'Face Cream'],
        ];

        foreach ($associations as $productIndex => $tagNames) {
            if (isset($products[$productIndex])) {
                $tagIds = [];
                foreach ($tagNames as $tagName) {
                    if (isset($tags[$tagName])) {
                        $tagIds[] = $tags[$tagName]->id;
                    }
                }
                $products[$productIndex]->tags()->attach($tagIds);
            }
        }
    }

    private function createReview(array $products): void
    {
        if (!isset($products[0])) {
            return;
        }

        $review = Review::create([
            'product_id' => $products[0]->id,
            'user_id' => 1,
            'name' => 'admin',
            'email' => 'admin@cosmetic.com',
            'rating' => 4,
            'comment' => 'Good product',
            'is_approved' => true,
        ]);

        $products[0]->updateRating();
    }

    private function createBanners(): void
    {
        $banner1Image = $this->downloadSimpleImage(
            'https://ippeo.in/wp-content/uploads/2026/05/banner1.png',
            'banners/banner1.png'
        );

        $banner2Image = $this->downloadSimpleImage(
            'https://ippeo.in/wp-content/uploads/2026/05/banner2.png',
            'banners/banner2.png'
        );

        $banners = [
            [
                'title' => 'Face Cleanser Darkness Protection',
                'subtitle' => 'Protect your skin with our advanced face cleanser for a radiant, healthy look',
                'image' => $banner1Image,
                'button_text' => 'SHOP NOW',
                'link' => 'https://amazon.in/dp/B0GZJLQ73N',
                'position' => 'home_slider',
                'order' => 1,
            ],
            [
                'title' => 'New Arrivals - Ippeo Skincare',
                'subtitle' => 'Discover our latest skincare innovations for glowing skin',
                'image' => $banner2Image,
                'button_text' => 'SHOP NOW',
                'link' => 'https://www.amazon.in/dp/B0GZJLQ73N',
                'position' => 'home_slider',
                'order' => 2,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::create([
                'title' => $banner['title'],
                'subtitle' => $banner['subtitle'],
                'image' => $banner['image'],
                'button_text' => $banner['button_text'],
                'link' => $banner['link'],
                'position' => $banner['position'],
                'order' => $banner['order'],
                'is_active' => true,
            ]);
        }
    }

    private function createTestimonials(): void
    {
        $testimonials = [
            [
                'name' => 'Jenifer Brown',
                'position' => 'Manager',
                'company' => 'AZ Corp',
                'testimonial' => 'Code, template and others are very good. The support has served me immediately and solved my problems when I need help. Are to be congratulated.',
                'rating' => 5,
            ],
            [
                'name' => 'Kathy Young',
                'position' => 'CEO',
                'company' => 'SunPark',
                'testimonial' => 'RoadThemes support and response has been amazing, helping me with several issues I came across and got them solved almost the same day. A pleasure to work with them!',
                'rating' => 5,
            ],
            [
                'name' => 'Katherine Sullivan',
                'position' => 'Customer',
                'company' => null,
                'testimonial' => 'These guys have been absolutely outstanding. Perfect Themes and the best of all that you have many options to choose! Best Support team ever! Very fast responding! Thank you very much! I highly recommend this theme and these people!',
                'rating' => 5,
            ],
        ];

        foreach ($testimonials as $index => $testimonial) {
            Testimonial::create([
                'name' => $testimonial['name'],
                'position' => $testimonial['position'],
                'company' => $testimonial['company'],
                'testimonial' => $testimonial['testimonial'],
                'image' => null,
                'rating' => $testimonial['rating'],
                'order' => $index,
                'is_active' => true,
            ]);
        }
    }

    private function createCmsPages(): void
    {
        CmsPage::create([
            'title' => 'About Us',
            'slug' => 'about-us',
            'content' => "Beauty Inspired by Nature, Crafted with Care\n\nAt Ippeo Essential Products, we believe that beauty starts with healthy, confident skin. Our mission is to provide premium-quality cosmetic and skincare products that combine innovation, effectiveness, and care.\n\nWe are passionate about creating products that help people look and feel their best every day. From skincare essentials to beauty-enhancing cosmetics, every product is carefully selected and tested to meet high standards of quality and customer satisfaction.\n\nOur commitment to excellence, transparency, and customer trust has made us a preferred choice for beauty enthusiasts seeking reliable and effective solutions.\n\nWE HAVE SKILLS TO SHOW\nProduct Quality: 95%\nSkincare Expertise: 99%\nCustomer Satisfaction: 90%\nBeauty Innovation: 96%",
            'template' => 'default',
            'is_active' => true,
            'meta_title' => 'About Us - Ippeo Essential Products',
            'meta_description' => 'Learn about Ippeo Essential Products - our mission, values, and commitment to quality skincare.',
            'meta_keywords' => 'about ippeo, skincare, beauty products, natural cosmetics',
        ]);
    }

    private function createSiteSettings(): void
    {
        $logoPath = $this->downloadSimpleImage(
            'https://ippeo.in/wp-content/uploads/2026/02/Selection__2_-removebg-preview-e1771697998579.png',
            'settings/site-logo.png'
        );

        $faviconPath = $this->downloadSimpleImage(
            'https://ippeo.in/wp-content/uploads/2026/02/cropped-Selection__4_-removebg-preview-e1771954624240-32x32.png',
            'settings/site-favicon.png'
        );

        $settings = [
            ['key' => 'site_name', 'value' => 'Ippeo Essential Products', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => "Nature's secret; Ippeo's promise", 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Ippeo brings the power of nature into your daily skincare routine with gentle, effective, and trusted essential products. Crafted with carefully selected ingredients, our formulas help protect, nourish, and refresh your skin while maintaining its natural balance.', 'type' => 'textarea', 'group' => 'general'],
            ['key' => 'site_logo', 'value' => $logoPath, 'type' => 'image', 'group' => 'general'],
            ['key' => 'site_favicon', 'value' => $faviconPath, 'type' => 'image', 'group' => 'general'],
            ['key' => 'footer_about', 'value' => 'Ippeo brings the power of nature into your daily skincare routine with gentle, effective, and trusted essential products.', 'type' => 'textarea', 'group' => 'general'],
            ['key' => 'contact_email', 'value' => 'info@ippeo.in', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '+91 74986 86978', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'contact_address', 'value' => "Ippeo Essentials Products\nSanand, Ahmedabad\nIndia", 'type' => 'textarea', 'group' => 'contact'],
            ['key' => 'support_email', 'value' => 'support@ippeo.in', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/ippeo', 'type' => 'text', 'group' => 'social'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/ippeo', 'type' => 'text', 'group' => 'social'],
            ['key' => 'meta_title', 'value' => "Ippeo Essential Products - Nature's secret; Ippeo's promise", 'type' => 'text', 'group' => 'seo'],
            ['key' => 'meta_description', 'value' => 'Ippeo brings the power of nature into your daily skincare routine with gentle, effective, and trusted essential products. Shop Vitamin C Face Wash, Glow Cream, Sunscreen SPF 50, and more.', 'type' => 'textarea', 'group' => 'seo'],
            ['key' => 'meta_keywords', 'value' => 'ippeo, skincare, vitamin c face wash, glow cream, sunscreen, face cream, face mask, natural beauty, cosmetics, india', 'type' => 'text', 'group' => 'seo'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::create($setting);
        }
    }

    private function createHomepageSections(): void
    {
        $sections = [
            [
                'section_name' => 'about',
                'title' => 'Ippeo',
                'subtitle' => 'up to 20% off',
                'content' => "Ippeo brings the power of nature into your daily skincare routine with gentle, effective, and trusted essential products. Crafted with carefully selected ingredients, our formulas help protect, nourish, and refresh your skin while maintaining its natural balance. Experience purity, care, and confidence with every use.",
                'image' => null,
                'button_text' => 'Shop now',
                'button_link' => 'https://www.amazon.in/dp/B0H1K1GDSL',
                'order' => 1,
            ],
        ];

        foreach ($sections as $section) {
            HomepageSection::create(array_merge($section, ['is_active' => true]));
        }
    }

    private function createFaqs(): void
    {
        $faqs = [
            [
                'question' => 'Are Ippeo products suitable for all skin types?',
                'answer' => 'Yes, our products are formulated to be gentle and effective for all skin types including dry, oily, combination, and sensitive skin. We recommend checking individual product ingredients for specific concerns.',
                'category' => 'Products',
            ],
            [
                'question' => 'How should I store my Ippeo products?',
                'answer' => 'Store in a cool, dry place away from direct sunlight. Keep the containers tightly closed after use to maintain product freshness.',
                'category' => 'Products',
            ],
            [
                'question' => 'Do you test on animals?',
                'answer' => 'No, we are proud to be cruelty-free. We never test our products on animals and are committed to ethical beauty practices.',
                'category' => 'Ethics',
            ],
            [
                'question' => 'How can I place an order?',
                'answer' => 'You can order directly from our website or through our Amazon store. Visit the Shop page to browse our products and add them to your cart.',
                'category' => 'Orders',
            ],
            [
                'question' => 'What is the delivery time?',
                'answer' => 'Standard delivery typically takes 3-7 business days depending on your location. We ship across India.',
                'category' => 'Shipping',
            ],
            [
                'question' => 'How can I contact customer support?',
                'answer' => 'You can reach us at support@ippeo.in or call us at +91 74986 86978. Our team is available to assist you with any questions or concerns.',
                'category' => 'Support',
            ],
            [
                'question' => 'What payment methods do you accept?',
                'answer' => 'We accept various payment methods including credit/debit cards, net banking, UPI, and cash on delivery for orders within India.',
                'category' => 'Orders',
            ],
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
}
