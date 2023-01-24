<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $title = 'Dashboard';

        return view('admin.dashboard', ['title' => $title]);
    }

    public function profile()
    {
        $title = 'Manage Profile';
        $profile = Auth::user();
        return view('admin.profile', ['title' => $title, 'profile' => $profile]);
    }

    public function do_profile(Request $request)
    {
        $this->validate($request, [
            'name' => 'unique:users,name|max:50|min:3',
            'email' => 'email|unique:users,email'

        ]);


        Auth::user()->update([
           'name' => $request->name,
           'email' => $request->email
        ]);


        return redirect()->back()->withSuccess('You have changed this settings successfully!');
    }

    public function do_changepassword(Request $request)
    {


        return view('admin.profile');
    }
}
