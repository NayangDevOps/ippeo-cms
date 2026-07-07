<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\HomepageSection;
use App\Models\Product;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        // Get active banners for slider
        $banners = Banner::active()
            ->where('position', 'home_slider')
            ->orderBy('order')
            ->get();

        // Get subcategories with products
        $categories = Category::where('is_active', true)
            ->whereNotNull('parent_id')
            ->orderBy('order')
            ->take(6)
            ->get();

        // Get featured products
        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->with('category')
            ->take(8)
            ->get();

        // Get new arrivals
        $newProducts = Product::where('is_active', true)
            ->where('is_new', true)
            ->with('category')
            ->latest()
            ->take(8)
            ->get();

        // Get bestsellers
        $bestSellers = Product::where('is_active', true)
            ->where('is_bestseller', true)
            ->with('category')
            ->take(8)
            ->get();

        // Get testimonials
        $testimonials = Testimonial::where('is_active', true)
            ->orderBy('order')
            ->take(6)
            ->get();

        // Get homepage sections
        $aboutSection = HomepageSection::where('section_name', 'about')
            ->where('is_active', true)
            ->first();

        return view('frontend.home', compact(
            'banners',
            'categories',
            'featuredProducts',
            'newProducts',
            'bestSellers',
            'testimonials',
            'aboutSection'
        ));
    }
}
