<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Cart;
use App\Models\Quotation;
use App\Models\SubCategory;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
{
    // Stats
    $totalUsers = User::count();
    $totalCarts = Cart::count();
    $totalQuotations = Quotation::count();
    $totalRevenue = Quotation::whereNotNull('response_details')->count() * 500; // Example

    $transactions = Quotation::count();

    // Weekly active users
    $weeklyActiveUsers = User::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
        ->where('created_at', '>=', now()->subDays(7))
        ->groupBy('date')
        ->pluck('total', 'date');

    // Revenue by user (or category, adjust as needed)
    $revenueByCategory = Quotation::select('user_id', DB::raw('count(*)*500 as revenue'))
        ->groupBy('user_id')
        ->pluck('revenue', 'user_id');

    // ✅ FIXED: Most popular items (by subcategory usage in carts)
    $popularItems = DB::table('cart_items')
        ->join('subcategories', 'cart_items.sub_category_id', '=', 'subcategories.id')
        ->select('subcategories.name', DB::raw('COUNT(cart_items.id) as sold'))
        ->groupBy('subcategories.name')
        ->orderByDesc('sold')
        ->limit(5)
        ->get();

    // Recent transactions (quotations)
    $recentTransactions = Quotation::with('user')
        ->latest()
        ->take(5)
        ->get();

    return view('home', compact(
        'totalUsers',
        'totalCarts',
        'totalQuotations',
        'totalRevenue',
        'transactions',
        'weeklyActiveUsers',
        'revenueByCategory',
        'popularItems',
        'recentTransactions'
    ));
}

    
}
