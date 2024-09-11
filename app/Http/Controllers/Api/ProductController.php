<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Illuminate\Http\Request;;
use App\Http\Resources\ProductResource;
use App\Http\Requests\ProductRequest;
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(20);
        return new ProductCollection($products);
    }
    public function store(ProductRequest $request)
    {
        $add_product = Product::create($request->validated());
        return response()->json($add_product, 201);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return new ProductResource($product);
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->validated());
        $product->save();
        return new ProductResource($product);
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return response()->json(['message' => 'Product deleted successfully'], 200);
        } catch (\exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
