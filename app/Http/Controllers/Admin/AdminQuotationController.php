<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use Illuminate\Http\Request;

class AdminQuotationController extends Controller
{
    // List all quotations with search
    public function index(Request $request)
    {
        $query = Quotation::with(['cart.items.subcategory', 'user', 'admin']);

        // Search by ID or User name
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('id', $search)
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%$search%");
                  });
        }

        $quotations = $query->latest()->paginate(20)->withQueryString();

        return view('admin.quotations.index', compact('quotations'));
    }

    // Show single quotation
    public function show(Quotation $quotation)
    {
        $quotation->load(['cart.items.subcategory', 'user', 'admin']);
        return view('admin.quotations.show', compact('quotation'));
    }

    // Optional: Update status by admin
    public function updateStatus(Request $request, Quotation $quotation)
    {
        $request->validate([
            'status' => 'required|in:Pending,Confirmed,Cancelled'
        ]);

        $quotation->update(['status' => $request->status]);

        return redirect()->route('admin.quotations.show', $quotation->id)
            ->with('success', 'Quotation status updated successfully!');
    }
}
