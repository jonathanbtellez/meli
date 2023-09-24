<?php

namespace App\Http\Controllers;

use App\Http\Traits\UserInfo;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
	use UserInfo;
	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function index()
	{
		$user = $this->validateUser(Auth::user());
		$products = Product::where('stock', '>', 0)->get();
		$categories = Category::with('products')->get();

		return view('home', compact('user', 'products', 'categories'));
	}
}
