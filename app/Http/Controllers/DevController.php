<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DevController extends Controller
{
    //
    public function dashboard()
    {
        return view('dev.dashboard');
    }

    public function userCount()
    {
        //get all user count
        $user_count = User::count();

        //get all auditor count
        $auditor_count = User::where('role', 'auditor')->count();

        //get all accountant count
        $accountant_count = User::where('role', 'accountant')->count();

        //get all members count
        $member_count = User::where('role', 'member')->count();

        return view('dev.dashboard', compact('user_count', 'auditor_count', 'accountant_count', 'member_count'));
    }

    public function user()
    {
        $users = User::all();
        return view('dev.show', compact('users'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('dev.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        // $request->validate([
        //     'role' => 'required',
        //  ]);

        $user->role = $request->get('role');
        $user->save();

        return redirect('/dev/manage')->with([
            'success' => 'User role updated!',
            'error' => `Can't update rolePlease try again.`
        ]);
    }

    public function destory($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/dev/manage')->with([
            'success' => 'User destroyed!'
        ]);

    }
}
