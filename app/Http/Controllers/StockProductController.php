<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockProductController extends Controller
{
    public function index()
    {
        return view('modules.stock.index');
    }
}
