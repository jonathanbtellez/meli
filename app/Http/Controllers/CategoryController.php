<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CategoryRequest;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
	public function getProducts(Request $request, Category $category)
	{
		if (Auth::user()) {
			$idUser = Auth::user()->id;
			$user = User::with('image', 'roles')->where('id', $idUser)->first();
		} else {
			$user = null;
		}
		$products = Product::where('stock', ">", 0)->get();
		$categories = Product::where('category_id', $category->id)->where('stock', '>', 0)->with('image')->get();

		return view('category.get-products', compact('user', 'products', 'categories', 'category'));
	}


	public function index()
	{
		if (Auth::user()) {
			$idUser = Auth::user()->id;
			$user = User::with('image', 'roles')->where('id', $idUser)->first();
		} else {
			$user = null;
		}

		$products = Product::where('stock', '>', 0)->get();
		return view('category.index', compact('user', 'products'));
	}

	public function store(CategoryRequest $request)
	{
		$category = new Category($request->all());
		$category->save();
		return response()->json($category, 201);
	}

	public function edit(Request $request, Category $category)
	{
		return response()->json($category, 200);
	}

	public function update(CategoryRequest $request, Category $category)
	{
		$category->update($request->all());
		return response()->json(['message' => 'the category was updated'], 204);
	}

	public function destroy(Request $request, Category $category)
	{
		$category->delete();
		return response()->json(['message' => 'the category was deleted'], 204);
	}

	public function getAllDt()
	{
		$category = Category::query();
		return DataTables::of($category)->toJson();
	}

}
