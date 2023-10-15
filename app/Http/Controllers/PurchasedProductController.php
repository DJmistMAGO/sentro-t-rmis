<?php

namespace App\Http\Controllers;

use App\Http\Requests\purchased_product\StoreRequest;
use App\Http\Requests\PurchasedRequest\UpdateRequest;
use App\Models\Product;
use App\Models\PurchaseProductInfo;
use Illuminate\Http\Request;
use Arr;

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

        $reference_no = PurchaseProductInfo::latest()->first('reference_no');
        $reference_no = $reference_no ? $reference_no->blotter_entry_no + 1 : 1;
        $reference_no = str_pad($reference_no, 4, '0', STR_PAD_LEFT);

        return view('modules.purchased.create', compact('products', 'reference_no'));
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

    public function edit(PurchaseProductInfo $prodPurInfo)
    {
        $products = Product::all();

        return view('modules.purchased.edit', compact('prodPurInfo', 'products'));
    }

    public function update(UpdateRequest $request, PurchaseProductInfo $prodPurInfo)
    {
        $validated = $request->validated();

        // dd($validated);

        $prodPurInfo->update(Arr::only($validated, [
            'reference_no',
            'prepared_by',
            'date_preparation',
        ]));

        $purchased_items = $prodPurInfo->purchasedProducts()->pluck('id');

        $deletedIds = $purchased_items->diff($validated['product_name'])->toArray();

        if ($deletedIds) {
            $prodPurInfo->purchasedProducts()->whereIn('id', $deletedIds)->delete();
        }

        foreach ($validated['product_name'] as $key => $product_item) {
            $product = Product::find($product_item);

            //find product and update the quantity
            $product->update([
                'quantity' => $product->quantity - $validated['quantity'][$key],
            ]);


            if (!$product_item) {
                $prodPurInfo->purchasedProducts()->create([
                    'product_id' => $validated['product_name'][$key],
                    'quantity' => $validated['quantity'][$key],
                    'price' => $product->price,
                    'total' => $validated['quantity'][$key] * $product->price,
                ]);
            } else {
                $prodPurInfo->purchasedProducts()->where('id', $product_item)->update([
                    'product_id' => $validated['product_name'][$key],
                    'quantity' => $validated['quantity'][$key],
                    'price' => $product->price,
                    'total' => $validated['quantity'][$key] * $product->price,
                ]);
            }


        }

        return redirect()->route('purchased-product.index')->with('success', 'Purchase Product updated successfully.');


    }
}
