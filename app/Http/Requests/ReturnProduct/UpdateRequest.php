<?php

namespace App\Http\Requests\ReturnProduct;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
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
        return [
            'reference_no' => 'required',
            'prepared_by' => 'required',
            'date_preparation' => 'required',

            'productId' => ['nullable', 'array'],
            'productId.*' => ['nullable', 'exists:return_products,id'],
            'product_name' => ['required', 'array'],
            'product_name.*' => ['required'],
            'quantity' => ['required', 'array'],
            'quantity.*' => ['required'],
        ];
    }
}
