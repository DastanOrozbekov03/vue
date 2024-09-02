<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Illuminate\Http\Request;;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return new ProductCollection($products);
    }
    public function store(Request $request)
    {
        $add_product = Product::create(request()->all());
        return $add_product;
    }
}
