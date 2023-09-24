<?php

namespace App\Http\Requests\User;

use App\Http\Requests\User\UserRequest;


class UserUpdateRequest extends UserRequest
{

    public function rules(): array
    {
		$this->rules['email'] = ['unique:users,email,'.$this->user->id];
		$this->rules['file'] = ['nullable','image'];
        return $this->rules;
    }
}
