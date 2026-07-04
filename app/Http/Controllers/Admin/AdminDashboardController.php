<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ContactInquiry;
use App\Models\Newsletter;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'total_categories' => Category::count(),
            'total_users' => User::where('role', 'user')->count(),
            'pending_reviews' => Review::where('is_approved', false)->count(),
            'new_inquiries' => ContactInquiry::where('status', 'new')->count(),
            'newsletter_subscribers' => Newsletter::where('is_subscribed', true)->count(),
        ];

        $recentProducts = Product::with('category')->latest()->take(5)->get();
        $recentInquiries = ContactInquiry::latest()->take(5)->get();
        $recentReviews = Review::with('product')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentProducts', 'recentInquiries', 'recentReviews'));
    }
}
