<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Http\Resources\CartCollection;
//use App\Models\Auth;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $cartItems = Cart::where('user_id', $userId)->get();
        return new CartCollection($cartItems);
    }
    public function add(Product $product)
    {

        dd(Session::get('token'));
        $userId =


        $cartItem = Cart::where('product_id', $product->id)
                        ->where('user_id', $userId)
                        ->first();

        dd($product->id, $userId);
        if ($cartItem) {
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

//    public function removeItem(CartRequest $request)
//    {
//        $cartItem = Cart::where('product_id', request('product_id'))->delete();
//
//        return response()->json(['message' => 'Product removed from cart']);
//    }
}
