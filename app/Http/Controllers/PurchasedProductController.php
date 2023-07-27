<?php

namespace App\Http\Controllers;

class PurchasedProductController extends Controller
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
