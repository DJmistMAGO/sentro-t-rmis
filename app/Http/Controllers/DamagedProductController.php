<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DamageProdInfo;
use App\Models\DamageProduct;
use App\Models\Product;
use App\Http\Requests\DamageProduct\StoreRequest;
use App\Http\Requests\DamageProduct\UpdateRequest;
use Arr;


class DamagedProductController extends Controller
{
    public function index()
    {
        return view('modules.damaged.index');
    }

    public function create()
    {
        $products = Product::get();

        $reference_no = DamageProdInfo::latest()->first('reference_no');
        $reference_no = $reference_no ? $reference_no->blotter_entry_no + 1 : 1;
        $reference_no = str_pad($reference_no, 4, '0', STR_PAD_LEFT);

        return view('modules.damaged.create', compact('products', 'reference_no'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();

        //create the data
        $purchased = DamageProdInfo::create([
            'user_id' => auth()->user()->id,
            'reference_no' => $validated['reference_no'],
            'prepared_by' => $validated['prepared_by'],
            'date_preparation' => $validated['date_preparation'],
        ]);

        //create product
        foreach ($validated['product_name'] as $key => $value) {

            $product = Product::find($value);

            $product->damageProducts()->create([
                'user_id' => auth()->user()->id,
                'quantity' => $validated['quantity'][$key],
                'price' => $product->price,
                'total' =>  $validated['quantity'][$key] *  $product->price,
                'damage_prod_info_id' => DamageProdInfo::latest()->first()->id,
            ]);
        }

        //find product and update the quantity
        foreach ($validated['product_name'] as $key => $value) {
            $product = Product::find($value);

            $product->update([
                'quantity' => $product->quantity - $validated['quantity'][$key],
            ]);
        }

        return redirect()->route('damaged-product.index')->with('success', 'Damaged Product created successfully.');
    }

    public function view(DamageProdInfo $purchased)
    {
        $purchased->load(['damageProducts']);
        $products = Product::all();
        // dd($purchased);

        return view('modules.damaged.view', compact('purchased', 'products'));
    }

    public function edit(DamageProdInfo $prodPurInfo)
    {
        $products = Product::all();

        return view('modules.damaged.edit', compact('prodPurInfo', 'products'));
    }

    public function update( UpdateRequest $request, DamageProdInfo $prodPurInfo)
    {
        $validated = $request->validated();

        // dd($prodPurInfo->damageProducts->quantity);

        $prodPurInfo->update(Arr::only($validated, [
            'reference_no',
            'prepared_by',
            'date_preparation',
        ]));

        $purchased_items = $prodPurInfo->damageProducts()->pluck('id');

        $deletedIds = $purchased_items->diff($validated['productId'])->toArray();

        if ($deletedIds) {
            foreach ($deletedIds as $key => $value) {
                $purchasedProd = DamageProduct::where('id', $deletedIds)->first();

                $product = Product::find($purchasedProd->product_id);

                $product->update([
                    'quantity' => $product->quantity + $purchasedProd->quantity,
                ]);
            }

            $prodPurInfo->damageProducts()->whereIn('id', $deletedIds)->delete();
        }

        foreach ($validated['productId'] as $key => $product_item) {
            $product = Product::find($validated['product_name'][$key]);

            $quantityToSubtract = $validated['quantity'][$key];

            if ($product_item) {
                $purchasedProduct = $prodPurInfo->damageProducts()->find($product_item);

                if ($purchasedProduct) {
                    // Update the product quantity based on the difference
                    $product->update([
                        'quantity' => $product->quantity + $purchasedProduct->quantity - $quantityToSubtract,
                    ]);

                    // Update the purchased product information
                    $purchasedProduct->update([
                        'product_id' => $validated['product_name'][$key],
                        'quantity' => $validated['quantity'][$key],
                        'price' => $product->price,
                        'total' => $validated['quantity'][$key] * $product->price,
                    ]);
                } else {
                    echo "Purchased product not found for ID: $product_item";
                }
            } else {
                // Create a new purchased product
                $prodPurInfo->damageProducts()->create([
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


        return redirect()->route('damaged-product.index')->with('success', 'Purchase Product updated successfully.');
    }
}
