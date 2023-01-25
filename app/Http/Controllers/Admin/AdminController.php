<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
}
