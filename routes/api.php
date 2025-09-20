<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OtpController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\CartItemController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\QuotationController;
use App\Http\Controllers\Api\SubCategoryController;
use App\Http\Controllers\Api\ConversationController;
use App\Http\Controllers\Api\NotificationController;

// Example route

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// login-user-details
Route::get('login-user-details', [AuthController::class, 'loginUserDetails'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
});


// Public routes


Route::get('/cart', [CartController::class, 'index'])->middleware('auth:sanctum');
Route::post('/cart', [CartController::class, 'store'])->middleware('auth:sanctum');
Route::post('/cart/add', [CartController::class, 'add']);
Route::delete('/cart/{id}', [CartController::class, 'remove'])->middleware('auth:sanctum');
Route::delete('/cart', [CartController::class, 'clear']);

Route::apiResource('cart-items', CartItemController::class);
Route::apiResource('subcategories', SubCategoryController::class);
Route::get('/subcategories/{id}', [SubCategoryController::class, 'show']);
Route::apiResource('favorites', FavoriteController::class)->middleware('auth:sanctum');
Route::post('/media', [MediaController::class, 'store']);          // Upload media
Route::get('/media/{type}/{id}', [MediaController::class, 'index']); // Get media by model
Route::apiResource('notifications', NotificationController::class);
Route::get('/search', [SearchController::class, 'search']);


// User: list and create quotations
Route::get('/quotations', [QuotationController::class, 'index']);
Route::post('/quotations', [QuotationController::class, 'store'])->middleware('auth:sanctum');
// Show a specific quotation
Route::get('/quotations/{quotation}', [QuotationController::class, 'show']);
// Admin: respond to quotation
Route::post('/quotations/{quotation}/respond', [QuotationController::class, 'respond']);


Route::post('resend-otp', [OtpController::class, 'store']);        // Generate OTP
Route::post('otps/verify', [OtpController::class, 'verify']); // Verify OTP
Route::delete('otps/expired', [OtpController::class, 'destroyExpired']); // Clean old OTPs

Route::prefix('conversations')->group(function () {
    Route::post('/', [ConversationController::class, 'store']); // start conversation
    Route::get('/', [ConversationController::class, 'index']); // list
    Route::get('/{id}', [ConversationController::class, 'show']); // single

    // Messages inside conversation
    Route::post('/{id}/messages', [MessageController::class, 'store']);
    Route::get('/{id}/messages', [MessageController::class, 'index']);
});


// Protected routes (need Sanctum token)
Route::middleware('auth:sanctum')->group(function () {


    // User CRUD
    Route::apiResource('users', UserController::class);
});


Route::apiResource('categories', CategoryController::class)->middleware('auth:sanctum');
Route::get('/categories/{id}', [CategoryController::class, 'show']);
