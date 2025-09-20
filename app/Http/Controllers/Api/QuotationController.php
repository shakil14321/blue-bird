<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Quotation;
use App\Models\QuotationDetail;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    // 1. User: List all their quotations / Admin: all quotations
    public function index(Request $request)
    {
        $query = Quotation::with(['cart.items.subcategory', 'user', 'admin'])->latest();

        if ($request->user()->role !== 'admin') {
            $query->where('user_id', $request->user()->id);
        }

        return $query->paginate(20);
    }

    // 2. User: Create a quotation request
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'event_date' => 'nullable|date',
            'phone' => 'required|string|max:20',
            'budget' => 'nullable|numeric|min:0',
            'location' => 'required|string|max:255',
        ]);

        // use try catch with database transaction
        try {
            DB::beginTransaction();

            $carts = Cart::where('user_id', $request->user()->id)->get();
            if (count($carts) === 0) {
                return response()->json(['message' => 'Cart is empty. Add items before requesting a quotation.'], 400);
            }
            $quotation = Quotation::create([
                'user_id' => $request->user()->id,
                'name' => $data['name'],
                'event_date' => $data['event_date'] ?? null,
                'phone' => $data['phone'],
                'budget' => $data['budget'] ?? null,
                'location' => $data['location'],
                'status' => 'Pending',
            ]);

            // QuotationDetail creation logic can be added here if needed
            foreach ($carts as $cart) {
                QuotationDetail::create([
                    'quotation_id' => $quotation->id,
                    'subcategories_id' => $cart->subcategories_id,
                    'quantity' => $cart->quantity,
                ]);
            }
            // Clear user's cart after creating quotation
            Cart::where('user_id', $request->user()->id)->delete();

            DB::commit();
            // return response json with for quotation with quotation details
            return response()->json([
                'message' => 'Quotation request created successfully.',
                'quotation' => $quotation->load('quotationDetails')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to create quotation request.', 'error' => $e->getMessage()], 500);
        }


    }

    // 3. Show a single quotation
    public function show(Request $request, Quotation $quotation)
    {
        // Restrict access: user sees only their own, admin sees all
        if ($request->user()->role !== 'admin') {
            abort_unless($quotation->user_id === $request->user()->id, 403, 'Unauthorized action.');
        }

        return $quotation->load('cart.items.subcategory', 'user', 'admin');
    }

    // 4. Admin: Respond to quotation
    public function respond(Request $request, Quotation $quotation)
    {
        abort_unless($request->user()->role === 'admin', 403, 'Only admin can respond.');

        $data = $request->validate([
            'response_details' => 'required|string'
        ]);

        $quotation->update([
            'response_details' => $data['response_details'],
            'admin_id' => $request->user()->id,
        ]);

        return $quotation->load('cart.items.subcategory', 'user', 'admin');
    }
}
