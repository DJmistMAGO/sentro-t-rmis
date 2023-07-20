<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('modules.product.index');
    }

    public function create()
    {
        return view('modules.product.create');
    }
}
