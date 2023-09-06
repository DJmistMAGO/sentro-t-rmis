<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ReturnProduct;
use App\Models\DamageProduct;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function home()
    {
        $return = ReturnProduct::all();
        $damage = DamageProduct::all();
        $products = Product::all();
        $productCount = Product::whereMonth('created_at', date('m'))->count();



        return view('dashboard', compact('products', 'productCount', 'damage', 'return'));
    }
}
