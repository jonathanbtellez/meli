<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
	protected $rules = [
		'name' => ['required', 'string', 'min:3'],
		'last_name' => ['required', 'string', 'min:3'],
		'email' => ['required', 'email', 'unique:users,email'],
		'password' => ['required', 'confirmed'],
		'file' => ['required','image',]
	];
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules(): array
	{
		return $this->rules;
	}

}
