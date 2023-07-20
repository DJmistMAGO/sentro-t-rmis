<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductPurchaseController extends Controller
{
    public function index()
    {
        return view('modules.purchased.index');
    }

    public function create()
    {
        return view('modules.purchased.create');
    }
}
