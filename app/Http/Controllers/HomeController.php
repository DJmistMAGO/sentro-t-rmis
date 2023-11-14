<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\DamageProduct;
use App\Models\ReturnProduct;
use App\Models\ReturnProdInfo;
use Illuminate\Support\Carbon;
use App\Models\PurchasedProduct;
use App\Models\PurchaseProductInfo;

class HomeController extends Controller
{
    public function home(Request $request)
    {

        $from = $request->input('from');
        $to = $request->input('to');

        $custom_sale = PurchaseProductInfo::with('purchasedProducts')
            ->whereBetween('date_preparation', [$from, $to])
            ->get();


        $monthlyTotals = [];

        foreach ($custom_sale as $cs) {
            $month = $cs->date_preparation->format('Y-m-d'); // Get the month abbreviation
            $total = $cs->purchasedProducts->sum('total');
            $monthlyTotals[$month] = ($monthlyTotals[$month] ?? 0) + $total;
        }

        $dataDatePrep = array_keys($monthlyTotals); // Month names
        $dataTotal = array_values($monthlyTotals);

        $products = Product::all();

        $productCount = Product::whereMonth('created_at', date('m'))->count();

        $out_stock_product = Product::whereMonth('created_at', date('m'))
            ->where('quantity', '<=', 10)
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

        $dailyTotals = [];

        // get todays date and filter purchasedProductsInfo with date_preparation = todays date and sum the total from the child model
        $today_date = date('Y-m-d');

        $todays_sales = PurchaseProductInfo::with('purchasedProducts')->where('date_preparation', '=', $today_date)->get();


        foreach ($todays_sales as $todays_sale) {
            $total = $todays_sale->purchasedProducts->sum('total');

            $dailyTotals[$today_date] = $total;
        }


        return view('dashboard', compact('dataTotal', 'dataDatePrep' ,'custom_sale', 'products', 'productCount', 'damage', 'return', 'monthlyTotals', 'out_stock_product'));
    }

    public function getChartData(Request $request)
    {
        $dateFilter = $request->input('dateFilter');
        $data = $this->fetchChartData($dateFilter, $request);
        return response()->json($data);
    }

    private function fetchChartData($dateFilter, $request)
    {
        $data = [
            'labels' => [],      // Store labels (e.g., dates)
            'salesData' => [],   // Store sales data
        ];

        // if ($dateFilter === 'today') {
        //     $today = now()->format('Y-m-d'); // Get the current date without time

        //     $todays_sales = PurchaseProductInfo::with('purchasedProducts')
        //         ->where('date_preparation', 'LIKE', $today . '%')
        //         ->get();

        //     foreach ($todays_sales as $todays_sale) {
        //         $data['labels'][] = $todays_sale->date_preparation->format('F d, Y');
        //         $total = $todays_sale->purchasedProducts->sum('total');
        //         $data['salesData'][] = $total;
        //     }
        // } else

        if ($dateFilter === 'thisWeek') {
            // Get the start and end of the current week
            $startOfWeek = now()->startOfWeek();
            $endOfWeek = now()->endOfWeek();

            // Initialize the labels with the days of the week
            $daysOfWeek = [
                'Monday' => [],
                'Tuesday' => [],
                'Wednesday' => [],
                'Thursday' => [],
                'Friday' => [],
                'Saturday' => [],
                'Sunday' => [],
            ];

            $weekly_sales = PurchaseProductInfo::with('purchasedProducts')
                ->whereBetween('date_preparation', [$startOfWeek, $endOfWeek])
                ->get();

            foreach ($weekly_sales as $weekly_sale) {
                $dayOfWeek = $weekly_sale->date_preparation->format('l'); // Get the full day name (e.g., Monday)
                $total = $weekly_sale->purchasedProducts->sum('total');
                // Add the total to the corresponding day of the week
                $daysOfWeek[$dayOfWeek][] = $total;
            }

            // Convert the daysOfWeek array to labels and salesData
            $data['labels'] = array_keys($daysOfWeek); // Days of the week
            $data['salesData'] = array_map(function ($daySales) {
                return array_sum($daySales); // Sum of sales for each day
            }, $daysOfWeek);

            return $data;
        } elseif ($dateFilter === 'thisYear') {
            $yearly_sales = PurchaseProductInfo::with('purchasedProducts')
                ->whereYear('date_preparation', '=', date('Y'))
                ->get();

            // Initialize an array to store monthly totals with default values
            $monthlyTotals = [
                'Jan' => 0,
                'Feb' => 0,
                'Mar' => 0,
                'Apr' => 0,
                'May' => 0,
                'Jun' => 0,
                'Jul' => 0,
                'Aug' => 0,
                'Sep' => 0,
                'Oct' => 0,
                'Nov' => 0,
                'Dec' => 0,
            ];

            // Calculate monthly totals
            foreach ($yearly_sales as $yearly_sale) {
                $month = $yearly_sale->date_preparation->format('M'); // Get the month abbreviation
                $total = $yearly_sale->purchasedProducts->sum('total');
                $monthlyTotals[$month] += $total;
            }

            // Set labels to be the month names and salesData to be the monthly totals
            $data['labels'] = array_keys($monthlyTotals); // Month names
            $data['salesData'] = array_values($monthlyTotals); // Monthly totals

            return $data;
        } elseif ($dateFilter === 'custom') {

            $from = $request->input('fromDate');
            $to = $request->input('toDate');

            $custom_sales = PurchaseProductInfo::with('purchasedProducts')
                ->whereBetween('date_preparation', [$from, $to])
                ->get();

            dd($custom_sales);

            $data['labels'] = array_keys($custom_sales->date_preparation); // Month names
            $data['salesData'] = array_values($custom_sales->purchasedProducts->sum('total'));

            // Rest of your code for processing custom sales data



            // $fromDate = $request->input('fromDate');
            // $toDate = $request->input('toDate');

            // // Convert the string dates to DateTime objects for easier date manipulation
            // $startDate = new \DateTime($fromDate);
            // $endDate = new \DateTime($toDate);

            // // Initialize an empty array to store the dates within the range
            // $dateRange = [];

            // // Generate an array of dates within the range
            // while ($startDate <= $endDate) {
            //     $dateRange[] = $startDate->format('Y-m-d');
            //     $startDate->modify('+1 day');
            // }

            // $custom_sales = PurchaseProductInfo::with('purchasedProducts')
            //     ->whereBetween('date_preparation', ['2023-01-01', '2023-11-01'])
            //     ->get();

            // dd($custom_sales);

            // // Initialize an array to store sales data for each date
            // $salesDataByDate = [];

            // foreach ($dateRange as $date) {
            //     $salesDataByDate[$date] = 0;
            // }

            // // Calculate sales data for each date
            // foreach ($custom_sales as $custom_sale) {
            //     $date = $custom_sale->date_preparation; // Use the existing date format
            //     $total = $custom_sale->purchasedProducts->sum('total');
            //     $salesDataByDate[$date] += $total;
            // }

            // // Set labels to be the dates in the custom range and salesData as the corresponding totals
            // $data['labels'] = $dateRange;
            // $data['salesData'] = array_values($salesDataByDate);
        }


        return $data;
    }
}
