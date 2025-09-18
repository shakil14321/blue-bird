<?php

namespace App\Http\Controllers\Api;

use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubCategoryController extends Controller
{
    // Get all subcategories
    public function index()
    {
        return SubCategory::with('category')->get();
    }

   
    // Show single subcategory
    public function show($id)
    {
        return SubCategory::with('category')->findOrFail($id);
         // Find related subcategories from the same category
        $related = SubCategory::where('category_id', $subcategory->category_id)
            ->where('id', '!=', $subcategory->id)
            ->limit(5) // limit to 5 suggestions
            ->get();

        return response()->json([
            'subcategory' => $subcategory,
            'related' => $related
        ]);
    }
}
