<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function index()
	{
		if (Auth::user()) {
			$idUser = Auth::user()->id;
			$user = User::where('id', $idUser)->with('image')->first();
		} else {
			$user = null;
		}

		$products = Product::where('stock', '>', 0)->get();
		$categories = Category::get();
		return view('home', compact('user', 'products', 'categories'));
	}
}
