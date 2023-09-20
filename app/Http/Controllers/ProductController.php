<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

	public function show(Request $request, Product $product)
    {
		if (Auth::user()) {
			$idUser = Auth::user()->id;
			$user = User::where('id', $idUser)->with('image')->first();
		} else {
			$user = null;
		}
		$products = Product::where('stock','>',0)->get();
		$product = Product::where('id',$product->id)->with('category','image')->first();
        return view('product.show', compact('user','products','product'));
    }
	public function getByCategory(Request $request, $id){
		$products = Product::where('category_id',$id)->where('stock','>',0)->with('image')->get();
		return response()->json([
			'products' => $products
		], 200);
	}

	public function getAll(){
		$products = Product::where('stock','>',0)->with('image')->get();
		return response()->json([
			'products' => $products
		], 200);
	}
}
