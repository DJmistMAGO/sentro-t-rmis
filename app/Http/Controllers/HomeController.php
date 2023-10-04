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


        $purchasedProductsInfo = PurchaseProductInfo::with('purchasedProducts')->whereYear('date_preparation', '=', date('Y'))->whereMonth('date_preparation', '=', date('m'))->get();

        $monthlyTotals = [];

        // Filter purchasedProductsInfo by month and sum the total from the child model
        foreach ($purchasedProductsInfo as $purchasedProductInfo) {
            $month = date('F', strtotime($purchasedProductInfo->date_preparation)); // Get the month name
            $total = $purchasedProductInfo->purchasedProducts->sum('total');

            // Store the total in the array with the month name as the key
            $monthlyTotals[$month] = $total;
        }

        // Create an array of month names
        $monthNames = [
            'January', 'February', 'March', 'April', 'May', 'June', 'July',
            'August', 'September', 'October', 'November', 'December'
        ];

        // Create an array with all months and set the sales to 0 for missing months
        foreach ($monthNames as $monthName) {
            if (!isset($monthlyTotals[$monthName])) {
                $monthlyTotals[$monthName] = 0;
            }
        }

        // Sort the array by month name
        // ksort($monthlyTotals);

        // dd($monthlyTotals);






        return view('dashboard', compact('products', 'productCount', 'damage', 'return', 'monthlyTotals' , 'out_stock_product'));
    }
}
