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
        $subcategory = SubCategory::with(['category', 'media'])->find($id);
        if (!$subcategory) {
            return response()->json(['message' => 'SubCategory not found'], 404);
        }
        return response()->json($subcategory, 200);
    }
}
