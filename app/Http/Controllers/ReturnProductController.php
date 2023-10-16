<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ReturnProdInfo;
use App\Models\ReturnProduct;
use Arr;
use App\Http\Requests\ReturnProduct\StoreRequest;
use App\Http\Requests\ReturnProduct\UpdateRequest;

class ReturnProductController extends Controller
{
    public function index()
    {
        return view('modules.return.index');
    }

    public function create()
    {
        $products = Product::get();

        $reference_no = ReturnProdInfo::latest()->first('reference_no');
        $reference_no = $reference_no ? $reference_no->blotter_entry_no + 1 : 1;
        $reference_no = str_pad($reference_no, 4, '0', STR_PAD_LEFT);

        return view('modules.return.create', compact('products', 'reference_no'));
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

    public function view(ReturnProdInfo $purchased)
    {
        $purchased->load(['returnProducts']);
        $products = Product::all();
        // dd($purchased);

        return view('modules.return.view', compact('purchased', 'products'));
    }

    public function edit(ReturnProdInfo $prodPurInfo)
    {
        $products = Product::all();

        return view('modules.return.edit', compact('prodPurInfo', 'products'));
    }

    public function update(UpdateRequest $request, ReturnProdInfo $prodPurInfo)
    {
        $validated = $request->validated();

        // dd($prodPurInfo->returnProducts->quantity);

        $prodPurInfo->update(Arr::only($validated, [
            'reference_no',
            'prepared_by',
            'date_preparation',
        ]));

        $purchased_items = $prodPurInfo->returnProducts()->pluck('id');

        $deletedIds = $purchased_items->diff($validated['productId'])->toArray();

        if ($deletedIds) {
            foreach ($deletedIds as $key => $value) {
                $purchasedProd = ReturnProduct::where('id', $deletedIds)->first();

                $product = Product::find($purchasedProd->product_id);

                $product->update([
                    'quantity' => $product->quantity - $purchasedProd->quantity,
                ]);
            }

            $prodPurInfo->returnProducts()->whereIn('id', $deletedIds)->delete();
        }

        foreach ($validated['productId'] as $key => $product_item) {
            $product = Product::find($validated['product_name'][$key]);

            $quantityToSubtract = $validated['quantity'][$key];

            if ($product_item) {
                $purchasedProduct = $prodPurInfo->returnProducts()->find($product_item);

                if ($purchasedProduct) {
                    // Update the product quantity based on the difference
                    $product->update([
                        'quantity' => $product->quantity - $purchasedProduct->quantity + $quantityToSubtract,
                    ]);

                    // Update the purchased product information
                    $purchasedProduct->update([
                        'product_id' => $validated['product_name'][$key],
                        'quantity' => $validated['quantity'][$key],
                        'price' => $product->price,
                        'total' => $validated['quantity'][$key] * $product->price,
                    ]);
                }

            } else {
                // Create a new purchased product
                $prodPurInfo->returnProducts()->create([
                    'product_id' => $validated['product_name'][$key],
                    'quantity' => $quantityToSubtract,
                    'price' => $product->price,
                    'total' => $quantityToSubtract * $product->price,
                ]);

                // Update the product quantity
                $product->update([
                    'quantity' => $product->quantity - $quantityToSubtract,
                ]);
            }
        }


        return redirect()->route('purchased-product.index')->with('success', 'Purchase Product updated successfully.');
    }
}
