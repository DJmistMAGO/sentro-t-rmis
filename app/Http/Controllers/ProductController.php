<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $search = $request->input('search');

        $query = Product::query();

        if ($search) {
            $query->where('product_name', 'like', '%' . $search . '%')
                ->orWhere('product_code', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orWhere('category', 'like', '%' . $search . '%');
        }

        $products = $query->paginate(10);

        return view('modules.product.index', compact('products'));
    }

    public function create()
    {
        return view('modules.product.create');
    }
}
