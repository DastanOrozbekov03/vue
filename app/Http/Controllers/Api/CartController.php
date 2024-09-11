<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Http\Resources\CartCollection;
//use App\Models\Auth;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {

        $userId = auth('sanctum')->id();
        if (!$userId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $cartItems = Cart::where('user_id', $userId)->get();
        return new CartCollection($cartItems);
    }

    public function add(Product $product)
    {
        $userId = auth('sanctum')->id();

        $cartItem = Cart::where('product_id', $product->id)
                        ->where('user_id', $userId)
                        ->first();


        if (!empty($cartItem)) {
            $cartItem->quantity++;
            $cartItem->save();
        } else {
            Cart::create([
                'product_id' => $product->id,
                'user_id' => $userId,
                'quantity' => 1,
            ]);
        }
        return response()->json(['message' => 'Product added to cart successfully']);
    }

    public function clear()
    {
        $userId = auth('sanctum')->id();

        if (!$userId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        Cart::where('user_id', $userId)->delete();

        return response()->json(['message' => 'Cart cleared successfully']);
    }
}
