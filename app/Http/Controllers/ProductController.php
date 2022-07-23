<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Like;

use Auth;

class ProductController extends Controller
{

    public function __construct(){
        $this->middleware('auth', ['except' => ['index', 'show']]);

    }
    public function index(){
        $products = Product::latest()->get();
        return view('products.index', compact('products'));
    }

    public function create(){
        return view('products.create');
    }

    public function destroy($id){
        if(!Auth::user()->is_admin){
            abort(403, 'Only admin can delete products');
        }

        $product = Product::findOrFail($id);
        $likes = Like::where('product_id', '=', $product->id)->delete();
        $product->delete();


        return redirect()->route('index')->with('status', 'Product has been deleted');
    }

    public function store(Request $request){
        $validated = $request->validate([

        'name'=>'required|min:3',
        'beschrijving'=>'required|min:20',
        'prijs'=>'required|min:1',
                // il faut changer le required
    ]);

// bij foute content komen we nooit hier, gaat terug naar form met error
    $product= new Product;
    $product->naam = $validated['name'];
    $product->beschrijving= $validated['beschrijving'];
    $product->prijs= $validated['prijs'];
    $product->user_id = Auth::user()->id;
    $product->save();

    return redirect()->route('index')->with('status','Product added');
    }

    public function edit($id){
        $product = Product::findOrFail($id);
        // 1:18:00
        // Encore le problème de Auth::user-> id comme dans index.blade.php
        if($product->user_id != Auth::id()) {
            abort(403);
        }

        return view('products.edit', compact('product'));
    }

    public function show($id){
        $product = Product::findOrFail($id);

        return view('products.show', compact('product'));
    }


    // 1:23:00
    public function update($id, Request $request){
        $product = Product::findOrFail($id);
        // 1:18:00
        // Encore le problème de Auth::user-> id comme dans index.blade.php
        if($product->user_id != Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([

            'name'=>'required|min:3',
            'beschrijving'=>'required|min:20',
            'prijs'=>'required|min:1',
                    // il faut changer le required
        ]);

        $product->naam = $validated['name'];
        $product->beschrijving= $validated['beschrijving'];
        $product->prijs= $validated['prijs'];
        $product->save();

        return redirect()->route('index')->with('status','Product edited');

    }

}