<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DamageProdInfo;
use App\Models\DamageProduct;
use App\Models\Product;
use App\Http\Requests\DamageProduct\StoreRequest;


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
}
