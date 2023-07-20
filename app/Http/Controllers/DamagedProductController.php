<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DamagedProductController extends Controller
{
    public function index()
    {
        return view('modules.damaged.index');
    }

    public function create()
    {
        return view('modules.damaged.create');
    }
}
