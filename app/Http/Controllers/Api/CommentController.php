<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Egulias\EmailValidator\Parser\Comment;
use Illuminate\Support\Facades\Cache;
use PhpParser\Node\Stmt\Case_;

class CommentController extends Controller
{
    public function index()
    {
        $comment = new Comment();
        $comment->body = $request->body;

        $product->comments()->save($comment);
        return redirect()->back();
    }

    public function cashe()
    {

        if (! Cache::has('products')) {
            Cache::put('products', Product::first(), now()->addMinutes(10));
        }

        $product = Cache::get('product');

        $product = Cashe::remember('product', now()->addMinutes(10), function () {
            return Product::first('product');
        }

    }


}
