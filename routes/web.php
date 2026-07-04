<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminBannerController;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminCmsPageController;
use App\Http\Controllers\Admin\AdminContactInquiryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminFaqController;
use App\Http\Controllers\Admin\AdminHomepageSectionController;
use App\Http\Controllers\Admin\AdminNewsletterController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\Admin\AdminSiteSettingController;
use App\Http\Controllers\Admin\AdminTagController;
use App\Http\Controllers\Admin\AdminTestimonialController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::post('/product/{product}/review', [ProductController::class, 'storeReview'])->name('products.review');

// Categories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/page/{slug}', [PageController::class, 'show'])->name('page.show');

// Newsletter
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::get('/newsletter/unsubscribe/{email}', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');

// Search
Route::get('/search', [ProductController::class, 'search'])->name('search');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// Admin Authentication
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    });

    // Authenticated routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Users Management
        Route::resource('users', AdminUserController::class)->except(['show']);
        Route::post('users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');

        // Categories Management
        Route::resource('categories', AdminCategoryController::class)->except(['show']);
        Route::post('categories/{category}/toggle-status', [AdminCategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

        // Products Management
        Route::resource('products', AdminProductController::class)->except(['show']);
        Route::post('products/{product}/toggle-status', [AdminProductController::class, 'toggleStatus'])->name('products.toggle-status');
        Route::post('products/{product}/toggle-featured', [AdminProductController::class, 'toggleFeatured'])->name('products.toggle-featured');
        Route::delete('products/{product}/image/{image}', [AdminProductController::class, 'deleteImage'])->name('products.delete-image');

        // Product Tags
        Route::resource('tags', AdminTagController::class)->except(['show']);

        // Product Reviews
        Route::get('reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
        Route::post('reviews/{review}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
        Route::delete('reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

        // Banners Management
        Route::resource('banners', AdminBannerController::class)->except(['show']);
        Route::post('banners/{banner}/toggle-status', [AdminBannerController::class, 'toggleStatus'])->name('banners.toggle-status');

        // Testimonials Management
        Route::resource('testimonials', AdminTestimonialController::class)->except(['show']);
        Route::post('testimonials/{testimonial}/toggle-status', [AdminTestimonialController::class, 'toggleStatus'])->name('testimonials.toggle-status');

        // Blog Management
        Route::resource('blogs', AdminBlogController::class)->except(['show']);
        Route::post('blogs/{blog}/toggle-publish', [AdminBlogController::class, 'togglePublish'])->name('blogs.toggle-publish');

        // FAQ Management
        Route::resource('faqs', AdminFaqController::class)->except(['show']);
        Route::post('faqs/{faq}/toggle-status', [AdminFaqController::class, 'toggleStatus'])->name('faqs.toggle-status');

        // CMS Pages Management
        Route::resource('cms-pages', AdminCmsPageController::class)->except(['show']);
        Route::post('cms-pages/{cmsPage}/toggle-status', [AdminCmsPageController::class, 'toggleStatus'])->name('cms-pages.toggle-status');

        // Contact Inquiries
        Route::get('contact-inquiries', [AdminContactInquiryController::class, 'index'])->name('contact-inquiries.index');
        Route::get('contact-inquiries/{contactInquiry}', [AdminContactInquiryController::class, 'show'])->name('contact-inquiries.show');
        Route::post('contact-inquiries/{contactInquiry}/mark-read', [AdminContactInquiryController::class, 'markRead'])->name('contact-inquiries.mark-read');
        Route::post('contact-inquiries/{contactInquiry}/mark-replied', [AdminContactInquiryController::class, 'markReplied'])->name('contact-inquiries.mark-replied');
        Route::delete('contact-inquiries/{contactInquiry}', [AdminContactInquiryController::class, 'destroy'])->name('contact-inquiries.destroy');

        // Newsletter Subscribers
        Route::get('newsletters', [AdminNewsletterController::class, 'index'])->name('newsletters.index');
        Route::delete('newsletters/{newsletter}', [AdminNewsletterController::class, 'destroy'])->name('newsletters.destroy');
        Route::get('newsletters/export', [AdminNewsletterController::class, 'export'])->name('newsletters.export');

        // Homepage Sections
        Route::resource('homepage-sections', AdminHomepageSectionController::class)->except(['show']);
        Route::post('homepage-sections/{homepageSection}/toggle-status', [AdminHomepageSectionController::class, 'toggleStatus'])->name('homepage-sections.toggle-status');

        // Site Settings
        Route::get('settings', [AdminSiteSettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [AdminSiteSettingController::class, 'update'])->name('settings.update');
    });
});
