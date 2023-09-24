<?php

namespace App\Http\Controllers;

use App\Http\Requests\purchased_product\StoreRequest;
use App\Models\Product;
use App\Models\PurchaseProductInfo;

class PurchasedProductController extends Controller
{
    public function index()
    {

        return view('modules.purchased.index');
    }

    public function create()
    {
        //get all products
        $products = Product::where('quantity', '>', 0)->get();

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

            //find product and update the quantity
            $product->update([
                'quantity' => $product->quantity - $validated['quantity'][$key],
            ]);

            $product->purchasedProducts()->create([
                'user_id' => auth()->user()->id,
                'quantity' => $validated['quantity'][$key],
                'price' => $product->price,
                'total' => $validated['quantity'][$key] * $product->price,
                'purchase_product_info_id' => PurchaseProductInfo::latest()->first()->id,
            ]);
        }

        return redirect()->route('purchased-product.index')->with('success', 'Purchased Product created successfully.');
    }

    public function view(PurchaseProductInfo $purchased)
    {
        $purchased->load(['purchasedProducts']);
        $products = Product::all();
        // dd($purchased);

        return view('modules.purchased.view', compact('purchased', 'products'));
    }

    // public function update(StoreRequest $request, PurchaseProductInfo $purchased)
    // {
    //     $validated = $request->validated();

    //     dd($validated);

    //     return redirect()->route('purchased-product.index')->with('success', 'Purchased Product record updated!');
    // }
}
