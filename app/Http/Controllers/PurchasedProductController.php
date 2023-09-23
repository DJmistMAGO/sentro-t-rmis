<?php

namespace App\Http\Controllers;

use App\Models\PurchaseProductInfo;
use App\Models\PurchasedProduct;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\purchased_product\StoreRequest;

class PurchasedProductController extends Controller
{
    public function index()
    {


        return view('modules.purchased.index');
    }

    public function create()
    {
        //get all products
        $products = Product::get();

        return view('modules.purchased.create', compact('products'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();

        //create the data
        $purchased = PurchaseProductInfo::create([
            'user_id' => auth()->user()->id,
            'reference_no' => $validated['reference_no'],
            'prepared_by' => $validated['prepared_by'],
            'date_preparation' => $validated['date_preparation'],
        ]);

        //create product
        foreach ($validated['product_name'] as $key => $value) {
            $product = Product::find($value);

            $product->purchasedProducts()->create([
                'user_id' => auth()->user()->id,
                'quantity' => $validated['quantity'][$key],
                'price' => $product->price,
                'total' =>  $validated['quantity'][$key] *  $product->price,
                'purchase_product_info_id' => PurchaseProductInfo::latest()->first()->id,
            ]);
        }

        //find product and update the quantity
        foreach ($validated['product_name'] as $key => $value) {
            $product = Product::find($value);

            $product->update([
                'quantity' => $product->quantity - $validated['quantity'][$key],
            ]);
        }

        return redirect()->route('purchased-product.index')->with('success', 'Purchased Product created successfully.');
    }
}
