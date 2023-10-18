<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
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
            'birthdate' => 'required',
            // 'user_id' => 'required',
            // 'password' => ['required', 'confirmed', 'min:8'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'contact_no' => $validated['contact_no'],
            'address' => $validated['address'],
            'birthdate' => $validated['birthdate'],
            // 'user_id' => $validated['user_id'],
            'password' => Hash::make('P@ssw0rd'),
        ]);

        return redirect()->route('user-management.index')->with('success', 'Successfully added new Staff!');
    }
    public function profileStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'contact_no' => 'required',
            'address' => 'required',
            'birthdate' => 'required',
            'user_id' => 'required',
        ]);

        $user = User::where('id', $validated['user_id'])->first();

        $user->update(Arr::only($validated, [
            'name',
            'email',
            'contact_no',
            'address',
            'birthdate',
        ]));


        return redirect()->back()->with('success', 'Successfully updated user-information!');
    }

    public function passwordUpdate(Request $request)
    {
        $validated = $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
            'user_id' => 'required',
        ]);

        $user = User::where('id', $validated['user_id'])->first();
        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->back()->with('success', 'Successfully updated password!');
    }

    public function viewProfile(User $user)
    {

        return view('users.user-profile.user-info');
    }

    public function viewStaff(User $user)
    {

        return view('users.user-profile.staff-info', compact('user'));
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

        $user->update(Arr::only($validated, [
            'name',
            'email',
            'contact_no',
            'address',
            'birthdate',
        ]));

        return redirect()->route('user-management.index')->with('success', 'Successfully updated Staff information!');
    }

    public function resetPass(User $user, Request $request)
    {
        $user->password = Hash::make('P@ssw0rd');
        $user->save();

        return redirect()->back()->with('success', 'Successfully reset password!');
    }

    public function destroy(User $user, Request $request)
    {
        $user->delete();

        return redirect()->route('user-management.index')->with('success', 'Successfully deleted Staff!');
    }
}
