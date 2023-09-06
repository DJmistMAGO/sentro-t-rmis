<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ReturnProdInfo;
use App\Models\ReturnProduct;
use App\Http\Requests\ReturnProduct\StoreRequest;
class ReturnProductController extends Controller
{
    public function index()
    {
        return view('modules.return.index');
    }

    public function create()
    {
        $products = Product::get();
        return view('modules.return.create', compact('products'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();

        //create the data
        ReturnProdInfo::create([
            'user_id' => auth()->user()->id,
            'reference_no' => $validated['reference_no'],
            'prepared_by' => $validated['prepared_by'],
            'date_preparation' => $validated['date_preparation'],
        ]);

        //create product
        foreach ($validated['product_name'] as $key => $value) {

            $product = Product::find($value);

            $product->returnProducts()->create([
                'user_id' => auth()->user()->id,
                'quantity' => $validated['quantity'][$key],
                'price' => $product->price,
                'total' =>  $validated['quantity'][$key] *  $product->price,
                'return_prod_info_id' => ReturnProdInfo::latest()->first()->id,
            ]);
        }

        //find product and update the quantity
        foreach ($validated['product_name'] as $key => $value) {
            $product = Product::find($value);

            $product->update([
                'quantity' => $product->quantity + $validated['quantity'][$key],
            ]);
        }

        return redirect()->route('returned-product.index')->with('success', 'Returned Product created successfully.');
    }
}
