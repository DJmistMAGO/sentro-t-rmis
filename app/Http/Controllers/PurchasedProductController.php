<?php

namespace App\Http\Controllers;

use App\Models\PurchaseProductInfo;
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
        PurchaseProductInfo::create([
            'reference_no' => $validated['reference_no'],
            'prepared_by' => $validated['prepared_by'],
            'date_preparation' => $validated['date_preparation'],
        ]);

        return redirect()->route('purchased-product.index')->with('success', 'Purchased Product created successfully.');
    }
}
