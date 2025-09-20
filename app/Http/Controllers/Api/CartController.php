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

    // Store a new cart
    public function store(Request $request)
    {
        $request->validate([
            'subcategories_id' => 'required|exists:subcategories,id',
            'quantity' => 'required|integer|min:1'
        ]);

        // Check if the item already exists in the cart
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('subcategories_id', $request->subcategories_id)
            ->first();

        if ($cartItem) {
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
        } else {
            $cartItem = Cart::create([
                'user_id' => Auth::id(),
                'subcategories_id' => $request->subcategories_id,
                'quantity' => $request->quantity
            ]);
        }

        return response()->json($cartItem->load('subcategory.category'), 201);

    }

    public function remove($id)
    {
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if (!$cartItem) {
            return response()->json(['message' => 'Cart item not found'], 404);
        }

        $cartItem->delete();
        return response()->json(['message' => 'Cart item removed']);
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
            'quantity' => 'required|integer|min:1'
        ]);

        $subcategory = SubCategory::findOrFail($request->subcategory_id);

        $cartItem = Cart::firstOrNew([
            'user_id' => Auth::id(),
            'subcategory_id' => $subcategory->id
        ]);

        $cartItem->quantity += $request->quantity;
        $cartItem->save();

        return response()->json([
            'message' => 'Subcategory added to cart',
            'cart_item' => $cartItem->load('subcategory.category')
        ]);
    }
}
