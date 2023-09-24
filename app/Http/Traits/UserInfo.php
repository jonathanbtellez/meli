<?php

namespace App\Http\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait UserInfo{

	/**
	 * Check if the user exist and then return and associative array with the info the user including image and roles
	 * @param mixed $user
	 */
	public function validateUser($user){
		$userValidate = null;
		if ($user) {
			$idUser = $user->id;
			$userValidate = User::with('image', 'roles')->where('id', $idUser)->first();
		}
		return $userValidate;
	}

}
