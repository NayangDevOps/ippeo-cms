-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 19, 2026 at 10:32 AM
-- Server version: 8.4.7
-- PHP Version: 8.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cosmetic_cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
CREATE TABLE IF NOT EXISTS `banners` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` enum('home_slider','home_banner','sidebar') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'home_slider',
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `subtitle`, `image`, `link`, `button_text`, `position`, `order`, `is_active`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(1, 'Welcome to Natural Beauty', 'Discover our range of organic cosmetic products', 'banners/banner1.jpg', '/products', 'Shop Now', 'home_slider', 1, 1, NULL, NULL, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(2, 'Summer Sale - 30% Off', 'Limited time offer on selected skincare essentials', 'banners/banner2.jpg', '/products', 'View Deals', 'home_slider', 2, 1, NULL, NULL, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(3, 'New Arrivals Collection', 'Fresh botanical formulas for glowing skin', 'banners/banner3.jpg', '/products', 'Explore', 'home_slider', 3, 1, NULL, NULL, '2026-06-17 07:47:27', '2026-06-17 07:47:27');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

DROP TABLE IF EXISTS `blogs`;
CREATE TABLE IF NOT EXISTS `blogs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_id` bigint UNSIGNED NOT NULL,
  `views` int NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `published_at` timestamp NULL DEFAULT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blogs_slug_unique` (`slug`),
  KEY `blogs_author_id_foreign` (`author_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `slug`, `excerpt`, `content`, `featured_image`, `author_id`, `views`, `is_published`, `published_at`, `meta_title`, `meta_description`, `meta_keywords`, `created_at`, `updated_at`) VALUES
(1, '10 Benefits of Natural Skincare', '10-benefits-of-natural-skincare', 'Discover why natural skincare products are better for your skin and the environment.', 'Natural skincare has gained immense popularity in recent years. Using products made from organic ingredients can significantly improve your skin health while reducing exposure to harsh chemicals.', 'blogs/10-benefits-of-natural-skincare.jpg', 1, 724, 1, '2026-05-06 07:47:27', '10 Benefits of Natural Skincare - Green Beauty Blog', 'Discover why natural skincare products are better for your skin and the environment.', NULL, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(2, 'How to Build a Morning Skincare Routine', 'how-to-build-a-morning-skincare-routine', 'A simple step-by-step guide to start your day with glowing skin.', 'A consistent morning routine sets the tone for healthy skin all day. Start with a gentle cleanser, follow with toner and serum, then lock in moisture with SPF protection.', 'blogs/how-to-build-a-morning-skincare-routine.jpg', 1, 344, 1, '2026-05-29 07:47:27', 'How to Build a Morning Skincare Routine - Green Beauty Blog', 'A simple step-by-step guide to start your day with glowing skin.', NULL, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(3, 'The Power of Vitamin C for Your Skin', 'the-power-of-vitamin-c-for-your-skin', 'Learn how vitamin C serums brighten, protect, and rejuvenate your complexion.', 'Vitamin C is one of the most researched skincare ingredients. It helps fade dark spots, boosts collagen production, and shields skin from environmental damage.', 'blogs/the-power-of-vitamin-c-for-your-skin.jpg', 1, 742, 1, '2026-06-11 07:47:27', 'The Power of Vitamin C for Your Skin - Green Beauty Blog', 'Learn how vitamin C serums brighten, protect, and rejuvenate your complexion.', NULL, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(4, '5 Organic Ingredients to Look For', '5-organic-ingredients-to-look-for', 'Know which natural ingredients deliver real results in your beauty products.', 'From aloe vera to rosehip oil, certain botanical ingredients have stood the test of time. Here are five must-have ingredients for any natural beauty regimen.', 'blogs/5-organic-ingredients-to-look-for.jpg', 1, 384, 1, '2026-04-27 07:47:27', '5 Organic Ingredients to Look For - Green Beauty Blog', 'Know which natural ingredients deliver real results in your beauty products.', NULL, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(5, 'Sustainable Beauty: Our Commitment', 'sustainable-beauty-our-commitment', 'How Green Beauty is reducing waste and sourcing responsibly.', 'Sustainability is at the heart of everything we do. From recyclable packaging to ethically sourced ingredients, we are committed to beauty that cares for the planet.', 'blogs/sustainable-beauty-our-commitment.jpg', 1, 592, 1, '2026-04-27 07:47:27', 'Sustainable Beauty: Our Commitment - Green Beauty Blog', 'How Green Beauty is reducing waste and sourcing responsibly.', NULL, '2026-06-17 07:47:27', '2026-06-17 07:47:27');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`),
  KEY `categories_parent_id_foreign` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `parent_id`, `order`, `is_active`, `meta_title`, `meta_description`, `meta_keywords`, `created_at`, `updated_at`) VALUES
(1, 'Face Care', 'face-care', 'Premium facial care products for radiant skin', 'categories/face-care.jpg', NULL, 0, 1, 'Face Care - Green Beauty', 'Premium facial care products for radiant skin', 'face care, natural cosmetics, organic beauty', '2026-06-17 07:47:25', '2026-06-17 07:47:25'),
(2, 'Cleansers', 'cleansers', 'Shop our Cleansers collection', 'categories/cleansers.jpg', 1, 0, 1, 'Cleansers - Green Beauty', 'Discover premium Cleansers made with natural ingredients.', NULL, '2026-06-17 07:47:25', '2026-06-17 07:47:25'),
(3, 'Toners', 'toners', 'Shop our Toners collection', 'categories/toners.jpg', 1, 1, 1, 'Toners - Green Beauty', 'Discover premium Toners made with natural ingredients.', NULL, '2026-06-17 07:47:25', '2026-06-17 07:47:25'),
(4, 'Face Masks', 'face-masks', 'Shop our Face Masks collection', 'categories/face-masks.jpg', 1, 2, 1, 'Face Masks - Green Beauty', 'Discover premium Face Masks made with natural ingredients.', NULL, '2026-06-17 07:47:25', '2026-06-17 07:47:25'),
(5, 'Body Care', 'body-care', 'Natural body care essentials for silky smooth skin', 'categories/body-care.jpg', NULL, 1, 1, 'Body Care - Green Beauty', 'Natural body care essentials for silky smooth skin', 'body care, natural cosmetics, organic beauty', '2026-06-17 07:47:25', '2026-06-17 07:47:25'),
(6, 'Body Lotions', 'body-lotions', 'Shop our Body Lotions collection', 'categories/body-lotions.jpg', 5, 0, 1, 'Body Lotions - Green Beauty', 'Discover premium Body Lotions made with natural ingredients.', NULL, '2026-06-17 07:47:25', '2026-06-17 07:47:25'),
(7, 'Body Scrubs', 'body-scrubs', 'Shop our Body Scrubs collection', 'categories/body-scrubs.jpg', 5, 1, 1, 'Body Scrubs - Green Beauty', 'Discover premium Body Scrubs made with natural ingredients.', NULL, '2026-06-17 07:47:25', '2026-06-17 07:47:25'),
(8, 'Hair Care', 'hair-care', 'Healthy hair solutions with botanical extracts', 'categories/hair-care.jpg', NULL, 2, 1, 'Hair Care - Green Beauty', 'Healthy hair solutions with botanical extracts', 'hair care, natural cosmetics, organic beauty', '2026-06-17 07:47:25', '2026-06-17 07:47:25'),
(9, 'Shampoos', 'shampoos', 'Shop our Shampoos collection', 'categories/shampoos.jpg', 8, 0, 1, 'Shampoos - Green Beauty', 'Discover premium Shampoos made with natural ingredients.', NULL, '2026-06-17 07:47:25', '2026-06-17 07:47:25'),
(10, 'Conditioners', 'conditioners', 'Shop our Conditioners collection', 'categories/conditioners.jpg', 8, 1, 1, 'Conditioners - Green Beauty', 'Discover premium Conditioners made with natural ingredients.', NULL, '2026-06-17 07:47:25', '2026-06-17 07:47:25'),
(11, 'Skincare', 'skincare', 'Complete skincare range for every skin type', 'categories/skincare.jpg', NULL, 3, 1, 'Skincare - Green Beauty', 'Complete skincare range for every skin type', 'skincare, natural cosmetics, organic beauty', '2026-06-17 07:47:25', '2026-06-17 07:47:25'),
(12, 'Moisturizers', 'moisturizers', 'Hydrating moisturizers for day and night', 'categories/moisturizers.jpg', NULL, 4, 1, 'Moisturizers - Green Beauty', 'Hydrating moisturizers for day and night', 'moisturizers, natural cosmetics, organic beauty', '2026-06-17 07:47:25', '2026-06-17 07:47:25'),
(13, 'Serums', 'serums', 'Powerful serums targeting specific skin concerns', 'categories/serums.jpg', NULL, 5, 1, 'Serums - Green Beauty', 'Powerful serums targeting specific skin concerns', 'serums, natural cosmetics, organic beauty', '2026-06-17 07:47:25', '2026-06-17 07:47:25');

-- --------------------------------------------------------

--
-- Table structure for table `cms_pages`
--

DROP TABLE IF EXISTS `cms_pages`;
CREATE TABLE IF NOT EXISTS `cms_pages` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `template` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cms_pages_slug_unique` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_pages`
--

INSERT INTO `cms_pages` (`id`, `title`, `slug`, `content`, `template`, `is_active`, `meta_title`, `meta_description`, `meta_keywords`, `created_at`, `updated_at`) VALUES
(1, 'About Us', 'about-us', 'Welcome to Green Beauty, your destination for premium natural cosmetics. Founded in 2018, we are dedicated to providing high-quality, organic beauty products that are good for you and the environment. Our mission is to help you achieve healthy, beautiful skin using only the finest natural ingredients sourced from sustainable farms around the world.', 'default', 1, NULL, NULL, NULL, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(2, 'Privacy Policy', 'privacy-policy', 'Your privacy is important to us. This privacy policy explains how we collect, use, and protect your personal information when you visit our website or make a purchase.', 'default', 1, NULL, NULL, NULL, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(3, 'Terms & Conditions', 'terms-conditions', 'By using our website, you agree to these terms and conditions. Please read them carefully before placing an order.', 'default', 1, NULL, NULL, NULL, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(4, 'Shipping & Returns', 'shipping-returns', 'We offer free standard shipping on orders over $50. Returns are accepted within 30 days of delivery for a full refund on unused products.', 'default', 1, NULL, NULL, NULL, '2026-06-17 07:47:27', '2026-06-17 07:47:27');

-- --------------------------------------------------------

--
-- Table structure for table `contact_inquiries`
--

DROP TABLE IF EXISTS `contact_inquiries`;
CREATE TABLE IF NOT EXISTS `contact_inquiries` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('new','read','replied') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_inquiries`
--

INSERT INTO `contact_inquiries` (`id`, `name`, `email`, `phone`, `subject`, `message`, `status`, `admin_notes`, `created_at`, `updated_at`) VALUES
(1, 'Alice Cooper', 'alice@email.com', '+1 (555) 729-1207', 'Product Question', 'Is the Rose Face Cream suitable for oily skin?', 'new', NULL, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(2, 'Bob Harris', 'bob@email.com', '+1 (555) 712-4961', 'Wholesale Inquiry', 'I am interested in wholesale pricing for my spa.', 'read', NULL, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(3, 'Carol White', 'carol@email.com', '+1 (555) 466-3989', 'Order Status', 'Can you provide an update on order #12345?', 'replied', NULL, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(4, 'Daniel Park', 'daniel@email.com', '+1 (555) 719-6308', 'Ingredient List', 'Please send the full ingredient list for the Vitamin C Serum.', 'new', NULL, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(5, 'Eva Rodriguez', 'eva@email.com', '+1 (555) 492-3409', 'Partnership', 'We would love to feature your products in our boutique.', 'read', NULL, '2026-06-17 07:47:27', '2026-06-17 07:47:27');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

DROP TABLE IF EXISTS `faqs`;
CREATE TABLE IF NOT EXISTS `faqs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `category`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Are your products organic?', 'Yes, all our products are made with certified organic ingredients sourced from sustainable farms.', 'Products', 0, 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(2, 'Do you test on animals?', 'No, we are proud to be cruelty-free. We never test our products on animals.', 'Ethics', 1, 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(3, 'What is your return policy?', 'We offer a 30-day money-back guarantee on all products. If you are not satisfied, we will refund your purchase.', 'Orders', 2, 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(4, 'How long does shipping take?', 'Standard shipping takes 3-5 business days. Express shipping is available for 1-2 day delivery.', 'Shipping', 3, 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(5, 'Are products safe for sensitive skin?', 'Most of our products are formulated for sensitive skin. Check individual product pages for allergen information.', 'Products', 4, 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(6, 'Do you ship internationally?', 'Yes, we ship to over 40 countries worldwide. Shipping costs are calculated at checkout.', 'Shipping', 5, 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(7, 'How should I store my products?', 'Store in a cool, dry place away from direct sunlight. Refrigeration is recommended for some serums.', 'Products', 6, 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(8, 'Can I use a discount code with sale items?', 'Discount codes cannot be combined with sale prices unless stated otherwise in the promotion.', 'Orders', 7, 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27');

-- --------------------------------------------------------

--
-- Table structure for table `homepage_sections`
--

DROP TABLE IF EXISTS `homepage_sections`;
CREATE TABLE IF NOT EXISTS `homepage_sections` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `section_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` text COLLATE utf8mb4_unicode_ci,
  `content` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `homepage_sections`
--

INSERT INTO `homepage_sections` (`id`, `section_name`, `title`, `subtitle`, `content`, `image`, `button_text`, `button_link`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'about', 'Natural Beauty, Naturally Made', 'Discover the power of nature', 'We believe in the power of natural ingredients. All our products are carefully crafted using organic, sustainable ingredients that are gentle on your skin and kind to the environment.', 'homepage/about-section.jpg', 'Learn More', '/about', 1, 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(2, 'promo', 'Clean Beauty You Can Trust', 'No parabens, no sulfates, no compromise', 'Every product in our collection is dermatologist-tested, ethically sourced, and packaged in recyclable materials.', 'homepage/promo-section.jpg', 'Shop Collection', '/products', 2, 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_tables', 1),
(2, '2024_01_01_000001_create_categories_table', 1),
(3, '2024_01_01_000002_create_products_table', 1),
(4, '2024_01_01_000003_create_product_images_table', 1),
(5, '2024_01_01_000004_create_product_variants_table', 1),
(6, '2024_01_01_000005_create_tags_table', 1),
(7, '2024_01_01_000006_create_reviews_table', 1),
(8, '2024_01_01_000007_create_banners_table', 1),
(9, '2024_01_01_000008_create_testimonials_table', 1),
(10, '2024_01_01_000009_create_blogs_table', 1),
(11, '2024_01_01_000010_create_faqs_table', 1),
(12, '2024_01_01_000011_create_cms_pages_table', 1),
(13, '2024_01_01_000012_create_contact_inquiries_table', 1),
(14, '2024_01_01_000013_create_newsletters_table', 1),
(15, '2024_01_01_000014_create_site_settings_table', 1),
(16, '2024_01_01_000015_create_homepage_sections_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

DROP TABLE IF EXISTS `newsletters`;
CREATE TABLE IF NOT EXISTS `newsletters` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_subscribed` tinyint(1) NOT NULL DEFAULT '1',
  `subscribed_at` timestamp NULL DEFAULT NULL,
  `unsubscribed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `newsletters_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `newsletters`
--

INSERT INTO `newsletters` (`id`, `email`, `is_subscribed`, `subscribed_at`, `unsubscribed_at`, `created_at`, `updated_at`) VALUES
(1, 'subscriber1@email.com', 1, '2026-03-21 07:47:27', NULL, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(2, 'subscriber2@email.com', 1, '2026-05-16 07:47:27', NULL, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(3, 'beautyfan@email.com', 1, '2026-04-24 07:47:27', NULL, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(4, 'skincarelover@email.com', 1, '2026-05-19 07:47:27', NULL, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(5, 'newsletter@email.com', 1, '2026-06-06 07:47:27', NULL, '2026-06-17 07:47:27', '2026-06-17 07:47:27');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `ingredients` longtext COLLATE utf8mb4_unicode_ci,
  `benefits` longtext COLLATE utf8mb4_unicode_ci,
  `usage_guide` longtext COLLATE utf8mb4_unicode_ci,
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_new` tinyint(1) NOT NULL DEFAULT '0',
  `is_bestseller` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `views` int NOT NULL DEFAULT '0',
  `rating` decimal(3,2) NOT NULL DEFAULT '0.00',
  `reviews_count` int NOT NULL DEFAULT '0',
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  UNIQUE KEY `products_sku_unique` (`sku`),
  KEY `products_category_id_foreign` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `sku`, `category_id`, `price`, `sale_price`, `stock`, `short_description`, `description`, `ingredients`, `benefits`, `usage_guide`, `featured_image`, `is_featured`, `is_new`, `is_bestseller`, `is_active`, `views`, `rating`, `reviews_count`, `meta_title`, `meta_description`, `meta_keywords`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Organic Rose Face Cream', 'organic-rose-face-cream', 'GB-0001', 1, 45.99, 39.99, 50, 'Luxurious rose-infused face cream for all skin types', 'Our premium organic rose face cream is formulated with pure rose essential oils and natural ingredients to deeply nourish and hydrate your skin.', 'Rose Extract, Aloe Vera, Vitamin E, Jojoba Oil, Shea Butter', 'Deeply moisturizes, Reduces fine lines, Brightens skin tone', 'Apply to clean face morning and night.', 'products/organic-rose-face-cream.jpg', 1, 1, 0, 1, 172, 4.33, 3, 'Organic Rose Face Cream - Green Beauty', 'Luxurious rose-infused face cream for all skin types', 'natural cosmetics, organic-rose-face-cream, organic skincare', '2026-06-17 07:47:25', '2026-06-17 07:47:27', NULL),
(2, 'Natural Vitamin C Serum', 'natural-vitamin-c-serum', 'GB-0002', 13, 35.99, NULL, 75, 'Powerful anti-aging vitamin C serum', 'Combat signs of aging with our potent vitamin C serum formulated to brighten, firm, and protect your skin.', 'Vitamin C, Hyaluronic Acid, Ferulic Acid, Vitamin E', 'Brightens complexion, Reduces dark spots, Firms skin', 'Apply as directed on packaging.', 'products/natural-vitamin-c-serum.jpg', 1, 0, 1, 1, 326, 5.00, 3, 'Natural Vitamin C Serum - Green Beauty', 'Powerful anti-aging vitamin C serum', 'natural cosmetics, natural-vitamin-c-serum, organic skincare', '2026-06-17 07:47:26', '2026-06-17 07:47:27', NULL),
(3, 'Hydrating Body Lotion', 'hydrating-body-lotion', 'GB-0003', 5, 28.99, NULL, 100, 'Ultra-hydrating body lotion with natural oils', 'Keep your skin soft and supple with our rich body lotion enriched with coconut oil and shea butter.', NULL, NULL, 'Apply as directed on packaging.', 'products/hydrating-body-lotion.jpg', 0, 1, 0, 1, 321, 4.50, 2, 'Hydrating Body Lotion - Green Beauty', 'Ultra-hydrating body lotion with natural oils', 'natural cosmetics, hydrating-body-lotion, organic skincare', '2026-06-17 07:47:26', '2026-06-17 07:47:27', NULL),
(4, 'Nourishing Hair Mask', 'nourishing-hair-mask', 'GB-0004', 8, 32.99, 27.99, 60, 'Deep conditioning hair mask with argan oil', 'Restore damaged hair with our intensive nourishing hair mask made with argan oil and keratin.', NULL, NULL, 'Apply as directed on packaging.', 'products/nourishing-hair-mask.jpg', 1, 0, 0, 1, 246, 5.00, 4, 'Nourishing Hair Mask - Green Beauty', 'Deep conditioning hair mask with argan oil', 'natural cosmetics, nourishing-hair-mask, organic skincare', '2026-06-17 07:47:26', '2026-06-17 07:47:27', NULL),
(5, 'Green Tea Face Cleanser', 'green-tea-face-cleanser', 'GB-0005', 2, 24.99, NULL, 120, 'Gentle green tea facial cleanser', 'Cleanse and refresh your skin with our antioxidant-rich green tea cleanser.', NULL, NULL, 'Apply as directed on packaging.', 'products/green-tea-face-cleanser.jpg', 0, 0, 0, 1, 142, 4.25, 4, 'Green Tea Face Cleanser - Green Beauty', 'Gentle green tea facial cleanser', 'natural cosmetics, green-tea-face-cleanser, organic skincare', '2026-06-17 07:47:26', '2026-06-17 07:47:27', NULL),
(6, 'Aloe Vera Moisturizer', 'aloe-vera-moisturizer', 'GB-0006', 12, 29.99, NULL, 80, 'Soothing aloe vera moisturizer', 'Calm and hydrate your skin with pure aloe vera gel and natural moisturizers.', NULL, NULL, 'Apply as directed on packaging.', 'products/aloe-vera-moisturizer.jpg', 0, 0, 1, 1, 495, 4.50, 2, 'Aloe Vera Moisturizer - Green Beauty', 'Soothing aloe vera moisturizer', 'natural cosmetics, aloe-vera-moisturizer, organic skincare', '2026-06-17 07:47:26', '2026-06-17 07:47:27', NULL),
(7, 'Lavender Night Cream', 'lavender-night-cream', 'GB-0007', 12, 42.99, NULL, 45, 'Relaxing lavender night cream for overnight repair', 'Wake up to refreshed skin with our calming lavender-infused night cream.', NULL, NULL, 'Apply as directed on packaging.', 'products/lavender-night-cream.jpg', 1, 1, 0, 1, 476, 5.00, 4, 'Lavender Night Cream - Green Beauty', 'Relaxing lavender night cream for overnight repair', 'natural cosmetics, lavender-night-cream, organic skincare', '2026-06-17 07:47:26', '2026-06-17 07:47:27', NULL),
(8, 'Rosehip Brightening Serum', 'rosehip-brightening-serum', 'GB-0008', 13, 38.99, 34.99, 55, 'Rosehip oil serum for even skin tone', 'Fade dark spots and even skin tone with cold-pressed rosehip oil.', NULL, NULL, 'Apply as directed on packaging.', 'products/rosehip-brightening-serum.jpg', 0, 0, 0, 1, 89, 4.50, 4, 'Rosehip Brightening Serum - Green Beauty', 'Rosehip oil serum for even skin tone', 'natural cosmetics, rosehip-brightening-serum, organic skincare', '2026-06-17 07:47:26', '2026-06-17 07:47:27', NULL),
(9, 'Coconut Body Scrub', 'coconut-body-scrub', 'GB-0009', 7, 26.99, NULL, 70, 'Exfoliating coconut sugar body scrub', 'Gently exfoliate and nourish with our coconut and brown sugar body scrub.', NULL, NULL, 'Apply as directed on packaging.', 'products/coconut-body-scrub.jpg', 0, 1, 0, 1, 133, 5.00, 2, 'Coconut Body Scrub - Green Beauty', 'Exfoliating coconut sugar body scrub', 'natural cosmetics, coconut-body-scrub, organic skincare', '2026-06-17 07:47:26', '2026-06-17 07:47:27', NULL),
(10, 'Argan Oil Shampoo', 'argan-oil-shampoo', 'GB-0010', 9, 22.99, NULL, 90, 'Sulfate-free argan oil shampoo', 'Cleanse hair gently while restoring shine with Moroccan argan oil.', NULL, NULL, 'Apply as directed on packaging.', 'products/argan-oil-shampoo.jpg', 0, 0, 0, 1, 290, 4.67, 3, 'Argan Oil Shampoo - Green Beauty', 'Sulfate-free argan oil shampoo', 'natural cosmetics, argan-oil-shampoo, organic skincare', '2026-06-17 07:47:26', '2026-06-17 07:47:27', NULL),
(11, 'Hyaluronic Acid Toner', 'hyaluronic-acid-toner', 'GB-0011', 3, 19.99, NULL, 110, 'Hydrating toner with hyaluronic acid', 'Prep your skin with a burst of hydration from our lightweight toner.', NULL, NULL, 'Apply as directed on packaging.', 'products/hyaluronic-acid-toner.jpg', 0, 0, 0, 1, 88, 4.67, 3, 'Hyaluronic Acid Toner - Green Beauty', 'Hydrating toner with hyaluronic acid', 'natural cosmetics, hyaluronic-acid-toner, organic skincare', '2026-06-17 07:47:26', '2026-06-17 07:47:27', NULL),
(12, 'Charcoal Detox Face Mask', 'charcoal-detox-face-mask', 'GB-0012', 4, 31.99, NULL, 65, 'Purifying charcoal clay face mask', 'Draw out impurities and minimize pores with activated charcoal and kaolin clay.', NULL, NULL, 'Apply as directed on packaging.', 'products/charcoal-detox-face-mask.jpg', 0, 0, 1, 1, 425, 4.50, 2, 'Charcoal Detox Face Mask - Green Beauty', 'Purifying charcoal clay face mask', 'natural cosmetics, charcoal-detox-face-mask, organic skincare', '2026-06-17 07:47:27', '2026-06-17 07:47:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
CREATE TABLE IF NOT EXISTS `product_images` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_primary` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_foreign` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `order`, `is_primary`, `created_at`, `updated_at`) VALUES
(1, 1, 'products/organic-rose-face-cream.jpg', 0, 1, '2026-06-17 07:47:25', '2026-06-17 07:47:25'),
(2, 1, 'products/organic-rose-face-cream-gallery-1.jpg', 1, 0, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(3, 1, 'products/organic-rose-face-cream-gallery-2.jpg', 2, 0, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(4, 2, 'products/natural-vitamin-c-serum.jpg', 0, 1, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(5, 2, 'products/natural-vitamin-c-serum-gallery-1.jpg', 1, 0, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(6, 2, 'products/natural-vitamin-c-serum-gallery-2.jpg', 2, 0, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(7, 3, 'products/hydrating-body-lotion.jpg', 0, 1, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(8, 3, 'products/hydrating-body-lotion-gallery-1.jpg', 1, 0, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(9, 3, 'products/hydrating-body-lotion-gallery-2.jpg', 2, 0, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(10, 4, 'products/nourishing-hair-mask.jpg', 0, 1, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(11, 4, 'products/nourishing-hair-mask-gallery-1.jpg', 1, 0, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(12, 4, 'products/nourishing-hair-mask-gallery-2.jpg', 2, 0, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(13, 5, 'products/green-tea-face-cleanser.jpg', 0, 1, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(14, 5, 'products/green-tea-face-cleanser-gallery-1.jpg', 1, 0, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(15, 5, 'products/green-tea-face-cleanser-gallery-2.jpg', 2, 0, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(16, 6, 'products/aloe-vera-moisturizer.jpg', 0, 1, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(17, 6, 'products/aloe-vera-moisturizer-gallery-1.jpg', 1, 0, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(18, 6, 'products/aloe-vera-moisturizer-gallery-2.jpg', 2, 0, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(19, 7, 'products/lavender-night-cream.jpg', 0, 1, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(20, 7, 'products/lavender-night-cream-gallery-1.jpg', 1, 0, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(21, 7, 'products/lavender-night-cream-gallery-2.jpg', 2, 0, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(22, 8, 'products/rosehip-brightening-serum.jpg', 0, 1, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(23, 8, 'products/rosehip-brightening-serum-gallery-1.jpg', 1, 0, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(24, 8, 'products/rosehip-brightening-serum-gallery-2.jpg', 2, 0, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(25, 9, 'products/coconut-body-scrub.jpg', 0, 1, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(26, 9, 'products/coconut-body-scrub-gallery-1.jpg', 1, 0, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(27, 9, 'products/coconut-body-scrub-gallery-2.jpg', 2, 0, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(28, 10, 'products/argan-oil-shampoo.jpg', 0, 1, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(29, 10, 'products/argan-oil-shampoo-gallery-1.jpg', 1, 0, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(30, 10, 'products/argan-oil-shampoo-gallery-2.jpg', 2, 0, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(31, 11, 'products/hyaluronic-acid-toner.jpg', 0, 1, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(32, 11, 'products/hyaluronic-acid-toner-gallery-1.jpg', 1, 0, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(33, 11, 'products/hyaluronic-acid-toner-gallery-2.jpg', 2, 0, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(34, 12, 'products/charcoal-detox-face-mask.jpg', 0, 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(35, 12, 'products/charcoal-detox-face-mask-gallery-1.jpg', 1, 0, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(36, 12, 'products/charcoal-detox-face-mask-gallery-2.jpg', 2, 0, '2026-06-17 07:47:27', '2026-06-17 07:47:27');

-- --------------------------------------------------------

--
-- Table structure for table `product_tag`
--

DROP TABLE IF EXISTS `product_tag`;
CREATE TABLE IF NOT EXISTS `product_tag` (
  `product_id` bigint UNSIGNED NOT NULL,
  `tag_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`product_id`,`tag_id`),
  KEY `product_tag_tag_id_foreign` (`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_tag`
--

INSERT INTO `product_tag` (`product_id`, `tag_id`) VALUES
(1, 1),
(1, 3),
(1, 4),
(1, 10),
(2, 2),
(2, 10),
(3, 2),
(3, 3),
(3, 4),
(4, 6),
(4, 7),
(5, 1),
(5, 2),
(6, 3),
(6, 9),
(7, 6),
(7, 7),
(8, 1),
(8, 3),
(8, 4),
(8, 10),
(9, 6),
(9, 7),
(9, 8),
(9, 9),
(10, 7),
(10, 8),
(10, 9),
(10, 10),
(11, 2),
(11, 8),
(12, 2),
(12, 4),
(12, 5),
(12, 8);

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

DROP TABLE IF EXISTS `product_variants`;
CREATE TABLE IF NOT EXISTS `product_variants` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_modifier` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_variants_product_id_foreign` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `name`, `type`, `price_modifier`, `sku`, `stock`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, '30ml', 'size', 0.00, 'GB-0001-30ML', 30, 1, '2026-06-17 07:47:26', '2026-06-17 07:47:26'),
(2, 1, '50ml', 'size', 8.00, 'GB-0001-50ML', 20, 1, '2026-06-17 07:47:26', '2026-06-17 07:47:26');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` int NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_product_id_foreign` (`product_id`),
  KEY `reviews_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `name`, `email`, `rating`, `comment`, `is_approved`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 'Michael Brown', 'mike.b@email.com', 4, 'Great quality and fast shipping. Highly recommend.', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(2, 1, 4, 'David Kim', 'david.k@email.com', 4, 'Nice texture and lovely natural scent.', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(3, 1, 6, 'Chris Martin', 'chris.m@email.com', 5, 'My wife loves it. Ordering more for gifts.', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(4, 2, 4, 'Jessica Lee', 'jessica.l@email.com', 5, 'Gentle on my sensitive skin. No irritation at all.', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(5, 2, 2, 'Anna Taylor', 'anna.t@email.com', 5, 'Visible results within two weeks. Impressed!', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(6, 2, 6, 'Chris Martin', 'chris.m@email.com', 5, 'My wife loves it. Ordering more for gifts.', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(7, 3, 4, 'Anna Taylor', 'anna.t@email.com', 5, 'Visible results within two weeks. Impressed!', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(8, 3, 2, 'Rachel Green', 'rachel.g@email.com', 4, 'Good value for money. Packaging is beautiful too.', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(9, 4, 5, 'Sarah Johnson', 'sarah.j@email.com', 5, 'Absolutely love this product! My skin feels amazing.', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(10, 4, 2, 'Emily Davis', 'emily.d@email.com', 5, 'Best natural product I have ever used. Will buy again!', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(11, 4, 6, 'Jessica Lee', 'jessica.l@email.com', 5, 'Gentle on my sensitive skin. No irritation at all.', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(12, 4, 6, 'Anna Taylor', 'anna.t@email.com', 5, 'Visible results within two weeks. Impressed!', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(13, 5, 5, 'Michael Brown', 'mike.b@email.com', 4, 'Great quality and fast shipping. Highly recommend.', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(14, 5, 4, 'David Kim', 'david.k@email.com', 4, 'Nice texture and lovely natural scent.', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(15, 5, 6, 'Rachel Green', 'rachel.g@email.com', 4, 'Good value for money. Packaging is beautiful too.', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(16, 5, 3, 'Chris Martin', 'chris.m@email.com', 5, 'My wife loves it. Ordering more for gifts.', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(17, 6, 4, 'Sarah Johnson', 'sarah.j@email.com', 5, 'Absolutely love this product! My skin feels amazing.', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(18, 6, 6, 'Rachel Green', 'rachel.g@email.com', 4, 'Good value for money. Packaging is beautiful too.', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(19, 7, 3, 'Sarah Johnson', 'sarah.j@email.com', 5, 'Absolutely love this product! My skin feels amazing.', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(20, 7, 3, 'Emily Davis', 'emily.d@email.com', 5, 'Best natural product I have ever used. Will buy again!', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(21, 7, 3, 'Jessica Lee', 'jessica.l@email.com', 5, 'Gentle on my sensitive skin. No irritation at all.', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(22, 7, 3, 'Anna Taylor', 'anna.t@email.com', 5, 'Visible results within two weeks. Impressed!', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(23, 8, 4, 'Sarah Johnson', 'sarah.j@email.com', 5, 'Absolutely love this product! My skin feels amazing.', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(24, 8, 5, 'Michael Brown', 'mike.b@email.com', 4, 'Great quality and fast shipping. Highly recommend.', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(25, 8, 5, 'Jessica Lee', 'jessica.l@email.com', 5, 'Gentle on my sensitive skin. No irritation at all.', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(26, 8, 5, 'David Kim', 'david.k@email.com', 4, 'Nice texture and lovely natural scent.', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(27, 9, 4, 'Sarah Johnson', 'sarah.j@email.com', 5, 'Absolutely love this product! My skin feels amazing.', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(28, 9, 6, 'Anna Taylor', 'anna.t@email.com', 5, 'Visible results within two weeks. Impressed!', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(29, 10, 3, 'Emily Davis', 'emily.d@email.com', 5, 'Best natural product I have ever used. Will buy again!', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(30, 10, 4, 'Michael Brown', 'mike.b@email.com', 4, 'Great quality and fast shipping. Highly recommend.', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(31, 10, 5, 'Anna Taylor', 'anna.t@email.com', 5, 'Visible results within two weeks. Impressed!', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(32, 11, 6, 'Emily Davis', 'emily.d@email.com', 5, 'Best natural product I have ever used. Will buy again!', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(33, 11, 3, 'Michael Brown', 'mike.b@email.com', 4, 'Great quality and fast shipping. Highly recommend.', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(34, 11, 3, 'Jessica Lee', 'jessica.l@email.com', 5, 'Gentle on my sensitive skin. No irritation at all.', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(35, 12, 5, 'Emily Davis', 'emily.d@email.com', 5, 'Best natural product I have ever used. Will buy again!', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(36, 12, 5, 'David Kim', 'david.k@email.com', 4, 'Nice texture and lovely natural scent.', 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE IF NOT EXISTS `site_settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_settings_key_unique` (`key`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `key`, `value`, `type`, `group`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'Green Beauty', 'text', 'general', '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(2, 'site_tagline', 'Natural Cosmetics for Everyone', 'text', 'general', '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(3, 'site_description', 'Premium natural and organic cosmetic products crafted with love. Shop skincare, haircare, and body care essentials.', 'textarea', 'general', '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(4, 'site_logo', 'settings/site-logo.png', 'image', 'general', '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(5, 'site_favicon', 'settings/site-favicon.png', 'image', 'general', '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(6, 'footer_about', 'We provide premium natural cosmetic products crafted with love and care. Every formula is vegan, cruelty-free, and made with sustainably sourced ingredients.', 'textarea', 'general', '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(7, 'contact_email', 'info@greenbeauty.com', 'text', 'contact', '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(8, 'contact_phone', '+1 (555) 123-4567', 'text', 'contact', '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(9, 'contact_address', '123 Beauty Street\nNew York, NY 10001\nUnited States', 'textarea', 'contact', '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(10, 'facebook_url', 'https://facebook.com/greenbeauty', 'text', 'social', '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(11, 'instagram_url', 'https://instagram.com/greenbeauty', 'text', 'social', '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(12, 'twitter_url', 'https://twitter.com/greenbeauty', 'text', 'social', '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(13, 'pinterest_url', 'https://pinterest.com/greenbeauty', 'text', 'social', '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(14, 'meta_title', 'Green Beauty - Natural Organic Cosmetics', 'text', 'seo', '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(15, 'meta_description', 'Shop premium natural skincare, haircare, and body care products. Organic, vegan, and cruelty-free beauty essentials.', 'textarea', 'seo', '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(16, 'meta_keywords', 'natural cosmetics, organic skincare, vegan beauty, cruelty-free, green beauty, face cream, serum', 'text', 'seo', '2026-06-17 07:47:27', '2026-06-17 07:47:27');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tags_slug_unique` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Organic', 'organic', '2026-06-17 07:47:25', '2026-06-17 07:47:25'),
(2, 'Vegan', 'vegan', '2026-06-17 07:47:25', '2026-06-17 07:47:25'),
(3, 'Cruelty-Free', 'cruelty-free', '2026-06-17 07:47:25', '2026-06-17 07:47:25'),
(4, 'Natural', 'natural', '2026-06-17 07:47:25', '2026-06-17 07:47:25'),
(5, 'Paraben-Free', 'paraben-free', '2026-06-17 07:47:25', '2026-06-17 07:47:25'),
(6, 'Sulfate-Free', 'sulfate-free', '2026-06-17 07:47:25', '2026-06-17 07:47:25'),
(7, 'Anti-Aging', 'anti-aging', '2026-06-17 07:47:25', '2026-06-17 07:47:25'),
(8, 'Hydrating', 'hydrating', '2026-06-17 07:47:25', '2026-06-17 07:47:25'),
(9, 'Brightening', 'brightening', '2026-06-17 07:47:25', '2026-06-17 07:47:25'),
(10, 'Sensitive Skin', 'sensitive-skin', '2026-06-17 07:47:25', '2026-06-17 07:47:25');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `testimonial` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` int NOT NULL DEFAULT '5',
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `position`, `company`, `testimonial`, `image`, `rating`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Sarah Johnson', 'Beauty Blogger', 'Glow Diary', 'These products are absolutely amazing! My skin has never looked better.', 'testimonials/avatar-1.jpg', 5, 0, 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(2, 'Emily Davis', 'Verified Customer', NULL, 'I have been using Green Beauty for 3 months and the results are incredible.', 'testimonials/avatar-2.jpg', 5, 1, 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(3, 'Michael Brown', 'Skincare Enthusiast', NULL, 'Great products with excellent customer service. Will definitely order again!', 'testimonials/avatar-3.jpg', 4, 2, 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(4, 'Priya Sharma', 'Dermatology Student', 'NYU', 'Finally found cosmetics that work for my sensitive skin without irritation.', 'testimonials/avatar-4.jpg', 5, 3, 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(5, 'Lisa Thompson', 'Makeup Artist', 'Studio Luxe', 'The natural ingredients make all the difference. Highly recommend to everyone.', 'testimonials/avatar-5.jpg', 5, 4, 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27'),
(6, 'James Wilson', 'Verified Customer', NULL, 'Beautiful packaging, lovely scents, and products that actually deliver results.', 'testimonials/avatar-6.jpg', 4, 5, 1, '2026-06-17 07:47:27', '2026-06-17 07:47:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `phone`, `address`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@admin.com', '2026-06-17 07:47:24', '$2y$12$79j97399Hem0JP5eIcTLAuT39YS2xyPNlaYcou2mQPqPC5UtUrS3.', 'admin', '+1 (555) 100-0001', '123 Beauty Street, New York, NY 10001', 1, NULL, '2026-06-17 07:47:24', '2026-06-17 07:47:24'),
(2, 'John Doe', 'john@example.com', '2026-06-17 07:47:24', '$2y$12$0YniSBNDWoD9D8J5GwvGXOBI32y4CqEb3qpCpuXrUjq5zj2jcBLxK', 'user', '+1 (555) 962-3437', NULL, 1, NULL, '2026-06-17 07:47:24', '2026-06-17 07:47:24'),
(3, 'Emma Wilson', 'emma@example.com', '2026-06-17 07:47:25', '$2y$12$RAhc4SGb2FesSgn0osNe7utelmaHPAPNY4b0Jsx9bJUqc/Vasi7G.', 'user', '+1 (555) 959-3454', NULL, 1, NULL, '2026-06-17 07:47:25', '2026-06-17 07:47:25'),
(4, 'Sophia Martinez', 'sophia@example.com', '2026-06-17 07:47:25', '$2y$12$or7vt8ZaneJrXXQUAtRVjeF.CP1p/VBE.j1j47sxvvTISEPeHM/hm', 'user', '+1 (555) 409-1990', NULL, 1, NULL, '2026-06-17 07:47:25', '2026-06-17 07:47:25'),
(5, 'Olivia Chen', 'olivia@example.com', '2026-06-17 07:47:25', '$2y$12$Lq8v8iEWD6aV5EqG1XZd6OAewTvfFNfdO8IcuplMC4m7MQU.i8q.6', 'user', '+1 (555) 302-3591', NULL, 1, NULL, '2026-06-17 07:47:25', '2026-06-17 07:47:25'),
(6, 'Liam Anderson', 'liam@example.com', '2026-06-17 07:47:25', '$2y$12$ipx80zIb.fz9qkHvfELjDe4xNmJLB7rDp4QQYMs8QPfk2SYsF0sJe', 'user', '+1 (555) 494-6546', NULL, 1, NULL, '2026-06-17 07:47:25', '2026-06-17 07:47:25');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
