<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\DamageProduct;
use App\Models\ReturnProduct;
use App\Models\ReturnProdInfo;
use Illuminate\Support\Carbon;
use App\Models\PurchasedProduct;
use App\Models\PurchaseProductInfo;

class HomeController extends Controller
{
    public function home()
    {
        // $return = ReturnProduct::all();
        // $damage = DamageProduct::all();
        $products = Product::all();

        $productCount = Product::whereMonth('created_at', date('m'))->count();

        $out_stock_product = Product::whereMonth('created_at', date('m'))
            ->where('quantity', '<=', 20)
            ->count();


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


        $purchasedProducts = PurchaseProductInfo::with('purchasedProducts')->get();
        $year = date('Y');
        $month = date('m');
        $monthCounts = [];

        foreach (range(1, 12) as $monthNumber) {
            $formattedMonth = str_pad($monthNumber, 2, '0', STR_PAD_LEFT);
            $monthCounts[$formattedMonth] = $purchasedProducts->filter(function ($purchasedProduct) use ($year, $formattedMonth) {
                return $purchasedProduct->date_preparation->format('Ym') == $year . $formattedMonth;
            })->count();
        }

        // dd($monthCounts);

        return view('dashboard', compact('products', 'productCount', 'damage', 'return', 'monthCounts' , 'out_stock_product'));
    }
}
