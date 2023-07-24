<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function home()
    {
        $products = Product::all();
        $productCount = Product::whereMonth('created_at', date('m'))->count(); //count products created this month

        return view('dashboard', compact('products', 'productCount'));
    }
}
