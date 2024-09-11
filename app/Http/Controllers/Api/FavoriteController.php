<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Product::whereHas('favorites', function ($query) {
            $query->where('user_id', auth('sanctum')->id());
        })->get();

//        $favorites = Favorite::where('user_id', auth('sanctum')->id())->pluck('favoritable_id')->toArray();
//        $products = Product::whereIn('id', $favorites)->get();

        return response()->json($favorites);
    }

    public function store(Request $request, $product_id)
    {
        $user = auth()->user();
        $product = Product::findOrFail($product_id);

//        if (!$user->favorites()->where('product_id', $product->id)->exists()) {
            $product->favorites()->create([
                'user_id' => auth('sanctum')->id()
            ]);

            return response()->json($product);
//        }
    }
    public function delete(Request  $request, $product_id)
    {
        $user = auth()->user();
        $product = Product::findOrFail($product_id);

        $product->favorites()->where('user_id', auth('sanctum')->id())->delete();
        return response()->json($product);

    }
}
