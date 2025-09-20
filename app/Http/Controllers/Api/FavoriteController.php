<?php

namespace App\Http\Controllers\Api;

use App\Models\Favorite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FavoriteController extends Controller
{
    public function index()
    {
        // get auth user favorites list
        return Favorite::with(['subcategory.media'])->where('user_id', auth()->id())->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'subcategory_id' => 'required|exists:subcategories,id'
        ]);
        // auth user add to favorite
        $favorite = Favorite::firstOrCreate([
            'user_id' => $request->user()->id,
            'subcategory_id' => $request->subcategory_id
        ]);

        return $favorite;
    }

    public function show($id)
    {
        return Favorite::with(['user', 'subcategory'])->findOrFail($id);
    }

    public function destroy($id)
    {
        return Favorite::destroy($id);
    }
}
