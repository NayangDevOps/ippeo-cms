<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::where('is_active', true)
            ->withCount('activeProducts')
            ->orderBy('name')
            ->get();

        return view('frontend.categories.index', compact('categories'));
    }

    public function show($slug, Request $request): View
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $query = $category->activeProducts()->with('category');

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(12);

        /** @phpstan-ignore-next-line */
        return view('frontend.categories.show', compact('category', 'products'));
    }
}
