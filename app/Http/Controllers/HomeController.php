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
        $currentDate = Carbon::now();
        $startOfMonth = $currentDate->startOfMonth();
        $endOfMonth = $currentDate->endOfMonth();

        $return = ReturnProduct::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $damage = DamageProduct::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();

        $products = Product::all();
        $productCount = Product::whereMonth('created_at', date('m'))->count();



        return view('dashboard', compact('products', 'productCount', 'damage', 'return'));
    }
}
