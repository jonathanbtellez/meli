<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
	public function index()
	{
		if (Auth::user()) {
			$idUser = Auth::user()->id;
			$user = User::with('image','roles')->where('id', $idUser)->first();
		} else {
			$user = null;
		}

		$products = Product::where('stock', '>', 0)->get();
		return view('user.index', compact('user', 'products'));
	}

	public function getAll()
	{
		$users = User::query()->with('roles')->get();
		return DataTables::of($users)->toJson();
	}
}
