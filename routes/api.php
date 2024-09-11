<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get("/test-me", function () {
return response()->json(['message' => 'Hello from Laravel API!']);
});

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::post('/products/create', [ProductController::class, 'store'])->name('products.store');
Route::get('/show/{product}', [ProductController::class, 'show'])->name('products.show');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');


Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/cart/add/{product}', [CartController::class, 'add'])->middleware('auth:sanctum')->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');


Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
Route::post('/favorite/{product_id}', [FavoriteController::class, 'store'])->middleware('auth:sanctum')->name('favorite.store');
Route::post('/favorite/{product_id}/delete', [FavoriteController::class, 'delete'])->name('favorite.delete');
