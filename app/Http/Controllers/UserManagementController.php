<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);

        return view('users.user-management', compact('users'));
    }

    public function create()
    {
        return view('users.create-user');
    }
}
