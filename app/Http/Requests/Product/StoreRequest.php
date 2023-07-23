<?php

namespace App\Http\Requests\Product;

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
            "product_name" => 'required',
            "product_code" => 'required',
            "description" => 'nullable',
            'category' => 'required',
            "price" => 'required',
            "quantity" => 'required',
            "image" => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5048'],
        ];
    }

    // public function message()
    // {
    //     return [
    //         "product_name.required" => "Product Name is required",
    //         "Product_code.required" => "Product Code is required",
    //         "price.required" => "Price is required",
    //         "quantity.required" => "Quantity is required",
    //         "image.required" => "Product Image is required",
    //         "image.max" => "Image must not exceed 5mb",
    //         "image.mimes" => "Image must be in formats accepted: jpeg, png, jpg, and/or gif",
    //     ];
    // }
}
