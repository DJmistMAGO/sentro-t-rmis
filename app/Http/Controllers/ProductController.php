<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public $categories = [
        'Electrical and Lighting',
        'Marine and Boating Supplies',
        'Home Improvement Materials',
        'Pumps and Plumbing Supplies',
        'Steel and Metal Products',
        'Wood and Timber Products',
        'Power Tools and Accessories',
        'Paints and Coatings',
        'Hardware and others',
    ];

    public function sample()
    {
        return view('modules.product.sample');
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Product::query()->orderBy('product_name', 'asc');

        if ($search) {
            $query->where('product_name', 'like', '%' . $search . '%')
                ->orWhere('product_code', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhere('category', 'like', '%' . $search . '%')
                ->orWhere('unit', 'like', '%' . $search . '%');
        }

        $products = $query->paginate(7);

        return view('modules.product.index', compact('products'));
    }

    public function create()
    {
        $categories = $this->categories;
        return view('modules.product.create', compact('categories'));
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();
        // dd($validated);

        $image = $request->file('image');
        $imageName = substr($image->getClientOriginalName(), 0, 5) . '.' . $image->extension();
        // $imageName = time() . '.' . $image->extension();

        // if public_path('img') does not exist, create it

        $image->move(public_path('img'), $imageName);

        Product::create([
            'product_name' => $validated['product_name'],
            'product_code' => $validated['product_code'],
            'description' => $validated['description'] ?? '',
            'category' => $validated['category'],
            'price' => $validated['price'],
            'unit' => $validated['unit'],
            'quantity' => $validated['quantity'],
            'image' => $imageName,
            'supplier_info' => $validated['supplier_info'] ?? '',
            'status' => 'available', //default
        ]);

        return redirect()->route('product.index')->with('success', 'Product record created successfully.');
    }

    public function edit(Product $product, $id)
    {
        $product = Product::findOrfail($id);
        $categories = $this->categories;

        return view('modules.product.edit', compact('product', 'categories'));
    }

    public function update(StoreRequest $request, $id)
    {
        $validated = $request->validated();
        // dd($validated);

        $product = Product::findOrfail($id);

        // delete old image
        if ($product->image && file_exists(public_path('img/' . $product->image))) {
            unlink(public_path('img/' . $product->image));
        }

        // upload new image
        $image = $request->file('image');
        $imageName = substr($image->getClientOriginalName(), 0, 5) . '.' . $image->extension();
        $image->move(public_path('img'), $imageName);

        $product->update([
            'product_name' => $validated['product_name'],
            'product_code' => $validated['product_code'],
            'description' => $validated['description'] ?? '',
            'category' => $validated['category'],
            'price' => $validated['price'],
            'quantity' => $validated['quantity'],
            'unit' => $validated['unit'],
            'supplier_info' => $validated['supplier_info'] ?? '',
            'image' => $imageName,
        ]);

        return redirect()->route('product.index')->with('success', 'Product record updated successfully.');
    }

    public function show(Product $product, $id)
    {
        $product = Product::findOrfail($id);
        $categories = $this->categories;

        return view('modules.product.view', compact('product', 'categories'));
    }
}
