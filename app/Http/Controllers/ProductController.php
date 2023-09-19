<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
	public function getByCategory(Request $request, $id){
		$products = Product::where('category_id',$id)->with('image')->get();
		return response()->json([
			'products' => $products
		], 200);
	}
}
