<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Contracts\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $blogs = Blog::published()
            ->with('author')
            ->latest('published_at')
            ->paginate(9);

        /** @phpstan-ignore-next-line */
        return view('frontend.blog.index', compact('blogs'));
    }

    public function show($slug): View
    {
        $blog = Blog::where('slug', $slug)
            ->published()
            ->with('author')
            ->firstOrFail();

        // Increment views
        $blog->incrementViews();

        // Recent blogs
        $recentBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        /** @phpstan-ignore-next-line */
        return view('frontend.blog.show', compact('blog', 'recentBlogs'));
    }
}
