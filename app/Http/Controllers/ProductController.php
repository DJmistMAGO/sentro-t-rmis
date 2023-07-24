<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Product::query()->orderBy('product_name', 'asc');

        if ($search) {
            $query->where('product_name', 'like', '%' . $search . '%')
                ->orWhere('product_code', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhere('category', 'like', '%' . $search . '%');
        }

        $products = $query->paginate(7);

        return view('modules.product.index', compact('products'));
    }

    public function create()
    {
        return view('modules.product.create');
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        // dd($validated);

        $image = $request->file('image');
        $imageName = time() . '.' . $image->extension();
        $image->move(public_path('img'), $imageName);

        Product::create([
            'product_name' => $validated['product_name'],
            'product_code' => $validated['product_code'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
            'image' => $imageName,
            'status' => 'ok', //test data
            'supplier_info' => 'Supplier_1', //test data
        ]);

        return redirect()->route('product.index')
            ->with('success', 'Product record created successfully.');
    }
}
