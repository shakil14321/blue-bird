<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Get all carts
   // View cart
    public function index()
    {
        $cartItems = Cart::with('subcategory.category')
            ->where('user_id', Auth::id())
            ->get();

        return response()->json($cartItems);
    }

    // // Store a new cart
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'user_id' => 'required|exists:users,id',
    //         'quotation_id' => 'nullable|integer',
    //     ]);

    //     return Cart::create($request->all());
    // }

    public function remove($id)
    {
        $item = Cart::where('user_id', Auth::id())->findOrFail($id);
        $item->delete();

        return response()->json(['message' => 'Item removed']);
    }

    // Delete cart
    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();
        return response()->json(['message' => 'Cart cleared']);
    }

    public function add(Request $request)
    {
        $request->validate([
            'subcategory_id' => 'required|exists:subcategories,id',
            'quantity'       => 'required|integer|min:1'
        ]);

        $subcategory = SubCategory::findOrFail($request->subcategory_id);

        $cartItem = Cart::firstOrNew([
            'user_id'       => Auth::id(),
            'subcategory_id'=> $subcategory->id
        ]);

        $cartItem->quantity += $request->quantity;
        $cartItem->save();

        return response()->json([
            'message'   => 'Subcategory added to cart',
            'cart_item' => $cartItem->load('subcategory.category')
        ]);
    }
}