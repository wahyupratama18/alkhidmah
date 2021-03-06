<?php

use App\Http\Controllers\{
    FilePondController,
    LandingController
};
use App\Http\Controllers\Admin\{
    CategoryController as AdminCategoryController,
    ProductController as AdminProductController
};
use App\Http\Controllers\Landing\{
    CategoryController,
    ProductController
};
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// All Access
Route::get('/', [LandingController::class, 'index'])->name('welcome');
Route::get('about', [LandingController::class, 'about'])->name('about');
Route::resource('category', CategoryController::class)
->only(['index', 'show'])
->scoped(['category' => 'slug']);

Route::get('product/{product:slug}', [ProductController::class, 'show'])->name('product.show');

Route::get('search', [LandingController::class, 'search'])->name('search');

// Authenticated user only
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::middleware('can:basicUser,user')->group(function () {
        // User Carts
        Route::get('carts', [LandingController::class, 'carts'])->name('carts');

        Route::post('product', [ProductController::class, 'store'])->name('product.store');
    });
    
    
    // Administrator Only
    Route::middleware('can:administrate,App\Models\User')->group(function () {
        // Dashboard
        Route::get('/dashboard', fn() => Inertia::render('Dashboard'))
        ->name('dashboard');

        Route::resource('categories', AdminCategoryController::class);
        Route::resource('categories.products', AdminProductController::class);

        Route::resource('pond', FilePondController::class)->only(['index', 'show', 'store', 'destroy']);
    });

});
