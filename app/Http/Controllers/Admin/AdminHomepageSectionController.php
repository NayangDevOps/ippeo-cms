<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminHomepageSectionController extends Controller
{
    public function index(Request $request)
    {
        $query = HomepageSection::query();

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $homepageSections = $query->orderBy('order')->paginate(15);

        return view('admin.homepage-sections.index', compact('homepageSections'));
    }

    public function create()
    {
        return view('admin.homepage-sections.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'section_name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|string|max:255',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('homepage', 'public');
        }

        HomepageSection::create($validated);

        return redirect()->route('admin.homepage-sections.index')->with('success', 'Section created successfully.');
    }

    public function edit(HomepageSection $homepageSection)
    {
        return view('admin.homepage-sections.edit', compact('homepageSection'));
    }

    public function update(Request $request, HomepageSection $homepageSection)
    {
        $validated = $request->validate([
            'section_name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'button_text' => 'nullable|string|max:50',
            'button_link' => 'nullable|string|max:255',
            'order' => 'integer',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($homepageSection->image) {
                Storage::disk('public')->delete($homepageSection->image);
            }
            $validated['image'] = $request->file('image')->store('homepage', 'public');
        }

        $homepageSection->update($validated);

        return redirect()->route('admin.homepage-sections.index')->with('success', 'Section updated successfully.');
    }

    public function destroy(HomepageSection $homepageSection)
    {
        if ($homepageSection->image) {
            Storage::disk('public')->delete($homepageSection->image);
        }

        $homepageSection->delete();

        return redirect()->route('admin.homepage-sections.index')->with('success', 'Section deleted successfully.');
    }

    public function toggleStatus(HomepageSection $homepageSection)
    {
        $homepageSection->update(['is_active' => ! $homepageSection->is_active]);

        return back()->with('success', 'Section status updated.');
    }
}
