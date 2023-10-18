<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Arr;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Models\PurchasedProduct;
use App\Models\PurchaseProductInfo;
use App\Http\Requests\purchased_product\StoreRequest;
use App\Http\Requests\PurchasedRequest\UpdateRequest;

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

        $purchased = PurchaseProductInfo::get();
        $reference_no = $purchased->max('reference_no') ?? 'PUR-2023-0000';
        $lastSeriesNo = substr($reference_no, 9, 4);
        // dd($lastSeriesNo);
        $seriesNo = str_pad($lastSeriesNo + 1, 4, '0', STR_PAD_LEFT);

        $reference_no = 'PUR-' . date('Y-') . $seriesNo;

        // dd($reference_no);

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

        LogActivity::addToLog('Stored a New Purchase Transaction Ref. No.: ' . $validated['reference_no']);


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

        // dd($prodPurInfo->purchasedProducts->quantity);

        $prodPurInfo->update(Arr::only($validated, [
            'reference_no',
            'prepared_by',
            'date_preparation',
        ]));

        $purchased_items = $prodPurInfo->purchasedProducts()->pluck('id');

        $deletedIds = $purchased_items->diff($validated['productId'])->toArray();

        if ($deletedIds) {
            foreach ($deletedIds as $key => $value) {
                $purchasedProd = PurchasedProduct::where('id', $deletedIds)->first();

                $product = Product::find($purchasedProd->product_id);

                $product->update([
                    'quantity' => $product->quantity + $purchasedProd->quantity,
                ]);
            }

            $prodPurInfo->purchasedProducts()->whereIn('id', $deletedIds)->delete();
        }

        foreach ($validated['productId'] as $key => $product_item) {
            $product = Product::find($validated['product_name'][$key]);

            $quantityToSubtract = $validated['quantity'][$key];

            if ($product_item) {
                $purchasedProduct = $prodPurInfo->purchasedProducts()->find($product_item);

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
                $prodPurInfo->purchasedProducts()->create([
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

        LogActivity::addToLog('Updated Purchased Transaction Ref. No.: ' . $validated['reference_no']);


        return redirect()->route('purchased-product.index')->with('success', 'Purchase Product updated successfully.');
    }
}
