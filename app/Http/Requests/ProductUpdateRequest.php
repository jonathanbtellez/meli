<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends ProductRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
		$this->rules['file'] = ['nullable','image'];
        return $this->rules;
    }
}
