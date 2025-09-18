<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminQuotationController;
use App\Http\Controllers\Admin\AdminSubCategoryController;
use App\Http\Controllers\HomeController;

// 🔹 Landing redirects to login
Route::get('/', function () {
    return redirect()->route('login');
});

// 🔹 Laravel default auth (disable registration if only admin can add users)
Auth::routes(['register' => true]);

// 🔹 Dashboard (home after login) – only for authenticated users
Route::get('/home', [HomeController::class, 'index'])
    ->name('home')
    ->middleware('auth');

// 🔹 Admin routes – only admin can access
Route::middleware(['auth'])->prefix('admin')->as('admin.')->group(function () {
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('subcategories', AdminSubCategoryController::class);
    Route::resource('users', AdminUserController::class);

    // Quotations
    Route::get('quotations', [AdminQuotationController::class, 'index'])->name('quotations.index');
    Route::get('quotations/{quotation}', [AdminQuotationController::class, 'show'])->name('quotations.show');
    Route::put('quotations/{quotation}/status', [AdminQuotationController::class, 'updateStatus'])->name('quotations.updateStatus');

    // Admin logout
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

// 🔹 Toggle user status (only admin)
Route::patch('/admin/users/{id}/toggle-status', [AdminUserController::class, 'toggleStatus'])
    ->name('admin.users.toggleStatus')
    ->middleware(['auth']);