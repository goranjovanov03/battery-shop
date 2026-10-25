<?php

use App\Http\Controllers\Api\AttributeController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    // Products
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/featured', [ProductController::class, 'featured']);
    Route::get('/products/{product:slug}', [ProductController::class, 'show']);
    Route::get('/products/{product:slug}/related', [ProductController::class, 'related']);

    // Categories
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/tree', [CategoryController::class, 'tree']);
    Route::get('/categories/{category:slug}', [CategoryController::class, 'show']);
    Route::get('/categories/{category:slug}/products', [CategoryController::class, 'products']);

    // Brands
    Route::get('/brands', [BrandController::class, 'index']);
    Route::get('/brands/{brand:slug}', [BrandController::class, 'show']);
    Route::get('/brands/{brand:slug}/products', [BrandController::class, 'products']);

    // Attributes (for filtering)
    Route::get('/attributes', [AttributeController::class, 'index']);
    Route::get('/attributes/filterable', [AttributeController::class, 'filterable']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
