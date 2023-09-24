<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Traits\UploadImage;
use App\Http\Requests\User\UserRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Traits\UserInfo;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
	use UploadImage, UserInfo;
	public function index()
	{
		$user = $this->validateUser(Auth::user());
		$products = Product::where('stock', '>', 0)->get();
		$roles = Role::all();
		return view('user.index', compact('user', 'products', 'roles'));
	}

	public function getAll()
	{
		$users = User::query()->with('roles');
		return DataTables::of($users)->toJson();
	}

	public function store(UserRequest $request)
	{
		try {
			DB::beginTransaction();
			$user = new User($request->all());
			$user->save();
			$user->assignRole($request->role);
			$this->uploadImage($user, $request);
			DB::commit();
			return response()->json(['message' => 'the user was created'], 200);
		} catch (\Throwable $th) {
			DB::rollBack();
			throw $th;
		}
	}

	public function show(Request $request, $id)
	{
		$user = User::with('image', 'roles')->where('id', $id)->first();
		return response()->json($user, 200);
	}

	public function update(UserUpdateRequest $request, User $user)
	{
		try {
			DB::beginTransaction();
			$user->update($request->all());
			$user->syncRoles([$request->role]);
			$this->uploadImage($user, $request);
			DB::commit();
			return response()->json([], 204);
		} catch (\Throwable $th) {
			DB::rollBack();
			throw $th;
		}
	}

	public function destroy(Request $request,User $user)
	{
		$user->delete();
		return response()->json([], 204);
	}
}
