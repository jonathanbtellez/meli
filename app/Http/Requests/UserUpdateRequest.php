<?php

namespace App\Http\Requests;

use App\Http\Requests\UserRequest;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends UserRequest
{

    public function rules(): array
    {
		$this->rules['email'] = ['unique:users,email,'.$this->user->id];
		$this->rules['file'] = ['nullable','image'];
        return $this->rules;
    }
}
