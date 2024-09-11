<?php

use App\Http\Middleware\EnsureTokenIsValid;
use Illuminate\Support\Facades\Route;

Route::get('/{vue_capture?}', function () {
    return view('welcome');
})->where('vue_capture', '[\/\w\.-]*');

//Route::middleware([EnsureTokenIsValid::class])->group(function () {
//
//});

Route::get('/', function () {
    dd('/products');
})->middleware('EnsureTokenIsValid');

Route::get('/products', function () {
    dd('/products');
})->name('products')->middleware('EnsureTokenIsValid');

Route::get('/products/{id}', function ($id) {
    dd('/products/' . $id);
})->name('cart');
