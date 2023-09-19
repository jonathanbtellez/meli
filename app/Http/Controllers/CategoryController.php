<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
	public function getProducts(Request $request,Category $category)
	{
		$user = Auth::user();
		$products = Product::where('stock',">",0)->get();
		$categories = Product::where('category_id',$category->id)->where('stock','>',0)->with('image')->get();

		return view('category.get-products', compact('user', 'products', 'categories', 'category'));
	}
}
