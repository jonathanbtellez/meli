<?php

namespace App\Http\Controllers;

use App\Http\Traits\UserInfo;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShoppingController extends Controller
{
	use UserInfo;
	public function index()
	{
		$user = $this->validateUser(Auth::user());
		$products = Product::where('stock', '>', 0)->with('image')->get();
		return view('shopping.index', compact('user', 'products'));
	}

	public function store(Request $request){
		$bought = $request->products;
		ProductUser::insert($bought);
		return response()->json([
			'The bought was saved'
		], 200);

	}
}
