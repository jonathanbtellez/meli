<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Login\RegisterRequest;
use App\Models\Image;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
	/*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

	use RegistersUsers;

	/**
	 * Where to redirect users after registration.
	 *
	 * @var string
	 */
	protected $redirectTo = RouteServiceProvider::HOME;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	public function register(RegisterRequest $request)
	{
		$user = new User($request->all());
		$user->save();
		$user->assignRole('user');
		$image = new Image(['url' => 'https://res.cloudinary.com/dso0xjfh8/image/upload/v1707697705/meli/456322_kgj76p.webp']);
		$user->image()->save($image);
		Auth::login($user);
		return redirect($this->redirectTo);
	}
}
