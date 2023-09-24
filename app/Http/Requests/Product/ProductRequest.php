<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
	protected $rules = [
		'name' => ['required','string','min:3'],
		'description' => ['required','string','min:25'],
		'stock' => ['required','gte:0'],
		'price' => ['required','integer'],
		'category_id' => ['required'],
		'file' => ['required','image'],
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
