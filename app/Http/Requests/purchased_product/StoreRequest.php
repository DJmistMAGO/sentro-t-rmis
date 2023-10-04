<?php

namespace App\Http\Requests\purchased_product;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'reference_no' => 'required',
            'prepared_by' => 'required',
            'date_preparation' => 'required',

            'product_name' => ['required', 'array'],
            'product_name.*' => ['required'],

            'quantity' => ['required', 'array'],
            'quantity.*' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'reference_no.required' => 'Reference Number is required',
            'prepared_by.required' => 'Prepared by field is required',
            'date_preparation.required' => 'Date of preparation is required',
            'product_name.required' => 'Product Name is required',
            'product_name.*.required' => 'Product Name is required',
            'quantity.required' => 'Quantity is required',
            'quantity.*.required' => 'Quantity is required',
        ];

    }
}
