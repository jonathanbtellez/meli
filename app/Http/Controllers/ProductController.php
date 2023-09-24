<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Traits\UploadImage;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
	use UploadImage;
	public function index()
	{
		if (Auth::user()) {
			$idUser = Auth::user()->id;
			$user = User::with('image', 'roles')->where('id', $idUser)->first();
		} else {
			$user = null;
		}

		$categories = Category::get();
		$products = Product::where('stock', '>', 0)->get();
		return view('product.index', compact('user', 'products','categories'));
	}

	public function store(ProductRequest $request)
	{
		try {
			DB::beginTransaction();
			$product = new Product([
				'name' => $request->name,
				'description' => $request->description,
				'stock' => $request->stock,
				'price' => $request->price,
				'category_id' => $request->category_id,
			]);
			$product->save();
			$this->uploadImage($product, $request);
			DB::commit();
			return response()->json(['message' => 'the product was created'], 201);
		} catch (\Throwable $th) {
			DB::rollBack();
			throw $th;
		}
	}

	public function update(ProductUpdateRequest $request, Product $product)
	{
		try {
			DB::beginTransaction();
			$product->update([
				'name' => $request->name,
				'description' => $request->description,
				'stock' => $request->stock,
				'price' => $request->price,
				'category_id' => $request->category_id,
			]);
			$this->uploadImage($product, $request);
			DB::commit();
			return response()->json(['message' => 'the product was updated'], 204);
		} catch (\Throwable $th) {
			DB::rollBack();
			throw $th;
		}
	}

	public function destroy(Request $request, Product $product)
	{
		$product->delete();
		return response()->json(['message' => 'the product was delete'], 204);
	}

	public function getAllDt()
	{
		$products = Product::query()->with('category');
		return DataTables::of($products)->toJson();
	}

	public function show(Request $request, Product $product)
	{
		if (Auth::user()) {
			$idUser = Auth::user()->id;
			$user = User::with('image', 'roles')->where('id', $idUser)->first();
		} else {
			$user = null;
		}
		$products = Product::where('stock', '>', 0)->get();
		$product = Product::where('id', $product->id)->with('category', 'image')->first();
		return view('product.show', compact('user', 'products', 'product'));
	}

	public function edit(Request $request, Product $product)
	{
		$product = Product::where('id', $product->id)->with('category', 'image')->first();
		return response()->json($product, 200);
	}
	public function getByCategory(Request $request, $id)
	{
		$products = Product::where('category_id', $id)->where('stock', '>', 0)->with('image')->get();
		return response()->json([
			'products' => $products
		], 200);
	}

	public function getAll()
	{
		$products = Product::where('stock', '>', 0)->with('image')->get();
		return response()->json([
			'products' => $products
		], 200);
	}
}
