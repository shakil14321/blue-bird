<?php

use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminSubCategoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Api\AuthController;

// Landing
Route::get('/', function () {
    return view('welcome');
});

// Default Laravel web auth (LoginController handles login)
Auth::routes(['register' => false]);


// Dashboard / home after login
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home')
    ->middleware('auth');

Route::middleware(['auth'])->prefix('admin')->as('admin.')->group(function () {
        Route::resource('categories', AdminCategoryController::class);
        Route::resource('subcategories', AdminSubCategoryController::class);
        Route::resource('users', UserController::class);
        Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');

    });
