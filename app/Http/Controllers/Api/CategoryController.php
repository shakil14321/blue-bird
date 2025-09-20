<?php

namespace App\Http\Controllers\api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    // Get all categories
    public function index()
    {
        return response()->json(Category::all(), 200);
    }

    // Show single category
    public function show($id)
    {
        $category = Category::with('subcategories.media')->find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        return response()->json($category, 200);
    }
}
