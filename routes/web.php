<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BatteryFinderController;
use App\Http\Controllers\BrandController as WebBrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController as WebCategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController as WebProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products', [WebProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [WebProductController::class, 'show'])->name('products.show');

Route::get('/categories', [WebCategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category:slug}', [WebCategoryController::class, 'show'])->name('categories.show');

Route::get('/brands', [WebBrandController::class, 'index'])->name('brands.index');
Route::get('/brands/{brand:slug}', [WebBrandController::class, 'show'])->name('brands.show');

// Cart routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::patch('/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/{id}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/', [CartController::class, 'clear'])->name('clear');
    Route::get('/count', [CartController::class, 'count'])->name('count');
});

// Checkout routes
Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/', [CheckoutController::class, 'store'])->name('store');
    Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('success');
});

// Search
Route::get('/search', [WebProductController::class, 'search'])->name('products.search');

// Battery finder
Route::get('/battery-finder', [BatteryFinderController::class, 'index'])->name('battery-finder.index');
Route::post('/battery-finder/search', [BatteryFinderController::class, 'search'])->name('battery-finder.search');
Route::post('/battery-finder/models', [BatteryFinderController::class, 'getModels'])->name('battery-finder.models');
Route::post('/battery-finder/engines', [BatteryFinderController::class, 'getEngines'])->name('battery-finder.engines');

// Account routes (authenticated)
Route::middleware('auth')->prefix('account')->name('account.')->group(function () {
    Route::get('/', [AccountController::class, 'index'])->name('index');
    Route::get('/orders/{order}', [AccountController::class, 'show'])->name('orders.show');
});

// Guest routes (login, register)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);

    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

// Logout
Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
})->name('logout');

// Payment routes
Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/process/{gateway}', [PaymentController::class, 'process'])->name('process');
    Route::get('/callback/{gateway}', [PaymentController::class, 'callback'])->name('callback');
    Route::get('/cancel/{gateway}', [PaymentController::class, 'cancel'])->name('cancel');
    Route::post('/webhook/{gateway}', [PaymentController::class, 'webhook'])->name('webhook');
});
