<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Product;
use Auth;

class LikeController extends Controller
{
    public function __construct(){
        $this->middleware('auth');

    }

    public function like($productid, Request $request){

        $product = Product::findOrFail($productid);
        if($product->user_id == Auth::user()->id){
            abort(403, 'You can not like your own product');
        }

        $like = Like::where('product_id', '=', $productid)->where('user_id', '=', Auth::user()->id)->first();
        if($like != NULL){
            abort(403,'You can not like a post more than once');
        }
        $like = new Like; 
        $like->user_id = Auth::user()->id; 
        $like->product_id = $productid;
        $like->save();

        return redirect()->route('index')->with('status', 'Product liked');
    }
}
