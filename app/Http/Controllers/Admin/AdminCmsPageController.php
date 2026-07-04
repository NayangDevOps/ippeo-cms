<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCmsPageController extends Controller
{
    public function index(Request $request)
    {
        $query = CmsPage::query();

        if ($request->filled('template')) {
            $query->where('template', $request->template);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $cmsPages = $query->latest()->paginate(15);
        $templates = CmsPage::distinct()->pluck('template')->filter();

        return view('admin.cms-pages.index', compact('cmsPages', 'templates'));
    }

    public function create()
    {
        return view('admin.cms-pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:cms_pages,slug',
            'content' => 'required|string',
            'template' => 'required|string|max:50',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);

        CmsPage::create($validated);

        return redirect()->route('admin.cms-pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(CmsPage $cmsPage)
    {
        return view('admin.cms-pages.edit', compact('cmsPage'));
    }

    public function update(Request $request, CmsPage $cmsPage)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:cms_pages,slug,'.$cmsPage->id,
            'content' => 'required|string',
            'template' => 'required|string|max:50',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['title']);

        $cmsPage->update($validated);

        return redirect()->route('admin.cms-pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(CmsPage $cmsPage)
    {
        $cmsPage->delete();

        return redirect()->route('admin.cms-pages.index')->with('success', 'Page deleted successfully.');
    }

    public function toggleStatus(CmsPage $cmsPage)
    {
        $cmsPage->update(['is_active' => ! $cmsPage->is_active]);

        return back()->with('success', 'Page status updated.');
    }
}
