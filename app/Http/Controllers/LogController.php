<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\LogActivity;

class LogController extends Controller
{
    public function index()
    {
        $logs = LogActivity::logActivityLists();

        return view('logs.index', compact('logs'));
    }
}
