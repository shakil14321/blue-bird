<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminSubCategoryController extends Controller
{
    public function index()
    {
        $subcategories = SubCategory::with('category')->get();
        $subcategories = SubCategory::paginate(10);
        return view('admin.subcategories.index', compact('subcategories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.subcategories.create', compact('categories'));
    }

    public function store(Request $request)
{
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'name'        => 'required|string|max:50',
        'description' => 'nullable|string',
        'images'      => 'nullable|array',
        'images.*'    => 'image|mimes:jpg,jpeg,png,gif|max:2048',
        'youtube_links' => 'nullable|array',
        'youtube_links.*' => 'nullable|url'
    ]);

    // Create subcategory
    $subcategory = SubCategory::create($request->only('category_id', 'name', 'description'));

    // Save uploaded images
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $path = $file->store('subcategories', 'public');

            $subcategory->media()->create([
                'media_type' => 'image',
                'url' => '/storage/' . $path,
            ]);
        }
    }

    // Save YouTube links
    if ($request->filled('youtube_links')) {
        foreach ($request->youtube_links as $link) {
            if (!empty($link)) {
                $subcategory->media()->create([
                    'media_type' => 'youtube',
                    'url' => $link,
                ]);
            }
        }
    }

    return redirect()->route('admin.subcategories.index')
                     ->with('success', 'Sub Category created successfully.');
}


    public function edit(SubCategory $subcategory)
    {
        $categories = Category::all();
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, SubCategory $subcategory)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:50',
            'description' => 'nullable|string',
        ]);

        $subcategory->update($request->only('category_id', 'name', 'description'));

        return redirect()->route('admin.subcategories.index')
                         ->with('success', 'Sub Category updated successfully.');
    }
    
    public function destroy(SubCategory $subcategory)
    {
        $subcategory->delete();
        return redirect()->route('admin.subcategories.index')
                         ->with('success', 'Sub Category deleted successfully.');
    }
}
