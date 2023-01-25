<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

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

        $profile = Auth::user();

        if ($request->photo)
        {
            $photoPath = $request->photo->storeAs('uploads', $profile->id.'.png', "public");
            $photo = Image::make(public_path("storage/{$photoPath}"))->resize(275, 275);
            $photo->save();

            Auth::user()->update([
                'name' => $request->name,
                'email' => $request->email,
                'image' => $photoPath,
            ]);
        }else{
            Auth::user()->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
        }



        return redirect()->back()->withSuccess('You have changed this settings successfully!');
    }

    public function do_changepassword(Request $request)
    {

        $request->validate([
            'password' => ['required', new MatchOldPassword],
            'new_password' => ['required', 'string', 'min:8'],
            'retype_new_password' => ['same:new_password'],
        ]);


        $user = auth()->user();


        $user->password = bcrypt($request->new_password);
        $user->save();

        return redirect()->back()->withSuccess('You have changed password successfully!');
    }

    public function manage_user(Request $request)
    {
        $title = 'Manage Users';
        $users = User::all();
        $search = $request->get('name');
        if ($search)
        {
            $users = User::where('name', 'like', '%'.$search.'%')->paginate(5);
        }

        return view('admin.manage_user',['title' => $title, 'users' => $users]);
    }

    public function user_add()
    {
        $title = 'Add Users';
        return view('admin.user_add',['title' => $title]);
    }

    public function do_user_add(Request $request)
    {

        $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8'],
            'role' => ['required'],
        ]);

        if ($request->role == 'user')
        {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ])->assignRole('user');
        }

        if ($request->role == 'manager')
        {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ])->assignRole('manager');
        }

        if ($request->role == 'admin')
        {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ])->assignRole('admin');
        }
        return redirect()->back()->withSuccess('You have added this user successfully!');
    }

    public function user_edit($id)
    {
        $title = 'Edit Users';
        $user = User::findOrFail($id);
        return view('admin.user_edit',['title' => $title, 'user' => $user]);
    }

    public function do_user_edit(Request $request)
    {

        $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($request->id),],
            'password' => ['required', 'min:8'],
            'role' => ['required'],
        ]);

        if ($request->role == 'user')
        {
            $user = User::find($request->id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            $user->assignRole('user');
        }

        if ($request->role == 'manager')
        {
            $user = User::find($request->id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            $user->assignRole('manager');
        }

        if ($request->role == 'admin')
        {
            $user = User::find($request->id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            $user->assignRole('admin');
        }
        return redirect()->back()->withSuccess('You have edited this user successfully!');
    }

    public function user_delete($id)
    {
        User::where('id', $id)->delete();

        return redirect()->back()->withSuccess('You have deleted this user successfully!');
    }

    public function settings()
    {
        return view('admin.settings');
    }
}
