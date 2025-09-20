<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:25',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        // Create category
        $category = Category::create([
            'name' => $request->name
        ]);

        // Handle images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                // store image with move function
                $path = $file->move('uploads/categories', uniqid() . '_' . $file->getClientOriginalName());

                $category->media()->create([
                    'media_type' => 'image',
                    'url' => $path,
                ]);
            }
        }

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }


    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:25'
        ]);

        // if  image is uploaded update it
        if ($request->hasFile('images')) {
            // upload new images
            foreach ($request->file('images') as $file) {
                $path = $file->move('uploads/categories', uniqid() . '_' . $file->getClientOriginalName());

                $category->media()->create([
                    'media_type' => 'image',
                    'url' => $path,
                ]);
            }
        }

        $category->update($request->only('name'));

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
