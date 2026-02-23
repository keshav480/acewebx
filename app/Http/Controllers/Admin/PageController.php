<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Str;

class PageController extends Controller
{
    // List pages with search & pagination
    public function index(Request $request)
    {
        $query = Page::query();

        // Search by title or slug
        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
        }

        // Order by 'order' column
        $pages = $query->orderBy('order')->paginate(10);

        // Preserve search query in pagination links
        $pages->appends($request->only('search'));

        return view('admin.pages.page.index', compact('pages'));
    }

    // Show create form
    public function create()
    {
        return view('admin.pages.page.create');
    }

    // Store new page
    public function store(Request $request)
    {
         $validated = $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|in:draft,published',
            'order' => 'nullable|integer',
         ]);

         // Generate a slug
         $slug = Str::slug($validated['title']);
         $count = Page::where('slug', 'LIKE', "{$slug}%")->count();
            if ($count > 0) {
               $slug .= '-' . ($count + 1);
            }

            // Create the page
            Page::create([
               'title' => $validated['title'],
               'status' => $validated['status'],
               'order' => $validated['order'] ?? 1,
               'slug' => $slug,
            ]);

        return redirect()->route('admin.pages.index')
                         ->with('success', 'Page created successfully.');
    }

    // Show edit form
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        return view('admin.pages.page.edit', compact('page'));
    }

    // Update page
    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $page->id,
            'status' => 'required|in:draft,published',
            'order' => 'nullable|integer',
        ]);

        $page->update($request->all());

        return redirect()->route('admin.pages.index')
                         ->with('success', 'Page updated successfully.');
    }

    // Delete page
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();

        return redirect()->route('admin.pages.index')
                         ->with('success', 'Page deleted successfully.');
    }
}
