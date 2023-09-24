<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\Product\ProductRequest;


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
