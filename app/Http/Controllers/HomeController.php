<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ReturnProduct;
use App\Models\ReturnProdInfo;
use App\Models\DamageProduct;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function home()
    {
        // $return = ReturnProduct::all();
        // $damage = DamageProduct::all();
        $products = Product::all();
        $productCount = Product::whereMonth('created_at', date('m'))->count();

        $return = ReturnProduct::with('returnProdInfo')
            ->whereHas('returnProdInfo', function ($query) {
                $currentMonth = Carbon::now()->format('m');
                $currentYear = Carbon::now()->format('Y');
                $query->whereMonth('date_preparation', '=', $currentMonth)
                ->whereYear('date_preparation', '=', $currentYear); // Adjust the month and year as needed
            })
            ->count();

            $damage = DamageProduct::with('damageProdInfo')
            ->whereHas('damageProdInfo', function ($query) {
                $currentMonth = Carbon::now()->format('m');
                $currentYear = Carbon::now()->format('Y');
                $query->whereMonth('date_preparation', '=', $currentMonth)
                ->whereYear('date_preparation', '=', $currentYear); // Adjust the month and year as needed
            })
            ->count(); 

        return view('dashboard', compact('products', 'productCount', 'damage', 'return'));
    }
}
