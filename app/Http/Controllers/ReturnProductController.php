<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReturnProductController extends Controller
{
    public function index()
    {
        return view('modules.return.index');
    }

    public function create()
    {
        return view('modules.return.create');
    }
}
