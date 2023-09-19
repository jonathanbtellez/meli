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
		$products = Product::get();
		$categories = Product::where('category_id', $category->id)->with('image')->get();
		return view('category.get-products', compact('user', 'products', 'categories', 'category'));
	}
}
