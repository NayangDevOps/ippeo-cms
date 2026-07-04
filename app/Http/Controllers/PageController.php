<?php

namespace App\Http\Controllers;

use App\Models\CmsPage;
use App\Models\Faq;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        $page = CmsPage::where('slug', 'about-us')
            ->where('is_active', true)
            ->first();

        /** @phpstan-ignore-next-line */
        return view('frontend.pages.about', compact('page'));
    }

    public function contact(): View
    {
        return view('frontend.pages.contact');
    }

    public function faq(): View
    {
        $faqs = Faq::where('is_active', true)
            ->orderBy('order')
            ->get()
            ->groupBy('category');

        return view('frontend.pages.faq', compact('faqs'));
    }

    public function show($slug): View
    {
        $page = CmsPage::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        /** @phpstan-ignore-next-line */
        return view('frontend.pages.show', compact('page'));
    }
}
