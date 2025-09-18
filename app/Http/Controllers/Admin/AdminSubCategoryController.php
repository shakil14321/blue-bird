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
        ]);

        SubCategory::create($request->only('category_id', 'name', 'description'));

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
