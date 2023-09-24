<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'contact_no' => 'required',
            'address' => 'required',
            'birthdate' => 'required'
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'contact_no' => $validated['contact_no'],
            'address' => $validated['address'],
            'birthdate' => $validated['birthdate'],
            'password' => Hash::make($validated['contact_no']),
        ]);

        return redirect()->route('user-management.index')->with('success', 'Successfuly added new staff account!');
    }

    public function viewProfile(User $user)
    {

    return view('users.user-profile.user-info');
    }

    public function viewStaff(User $user)
    {

    return view('users.user-profile.staff-info' , compact('user'));
    }

    public function updateStaff(User $user, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'contact_no' => 'required',
            'address' => 'required',
            'birthdate' => 'required'
        ]);
    }


}
