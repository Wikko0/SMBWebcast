<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Meeting;
use App\Models\Team;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function dashboard()
    {
        $title = 'Dashboard';

        $team_leader = Team::where('user', Auth::user()->name)->first();

        $today = Carbon::today();
        $hostToday = Meeting::where('created_by', $team_leader->created_by)->whereDate('created_at', $today)->count();
        $joinedToday = Meeting::where('created_by', $team_leader->created_by)->whereDate('created_at', $today)->sum('joined');
        $userRegister = Auth::user()->team->where('created_by', $team_leader->created_by)->count('user');
        $userRegisterToday = Auth::user()->team->where('created_by', $team_leader->created_by)->whereDate('created_at', $today)->count('user');
        $commonModel = new Common();
        $getDay = $commonModel->get_days_of_this_month();
        $joined = $commonModel->joined_meeting_this_month_chart_data_user();
        $hosted = $commonModel->hosted_meeting_this_month_chart_data_user();
        $yearlyJoined = $commonModel->yearly_join_meeting_chart_data_user();
        $yearlyHosted = $commonModel->yearly_host_meeting_chart_data_user();
        return view('user.dashboard', [
            'yearlyHosted' => $yearlyHosted,
            'yearlyJoined' => $yearlyJoined,
            'hosted' => $hosted,
            'joined' => $joined,
            'getDay' => $getDay,
            'title' => $title,
            'hostToday' => $hostToday,
            'joinedToday' => $joinedToday,
            'userRegister' => $userRegister,
            'userRegisterToday' => $userRegisterToday]);
    }

    public function profile()
    {
        $title = 'Manage Profile';
        $profile = Auth::user();
        return view('user.profile', ['title' => $title, 'profile' => $profile]);
    }

    public function do_profile(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:50','min:3', Rule::unique('users')->ignore($request->id),],
            'email' => ['required', 'email', Rule::unique('users')->ignore($request->id),],
            'photo' => 'mimes:jpeg,png,jpg,gif'
        ]);

        $profile = Auth::user();

        if ($request->photo)
        {
            $file = $request->file("photo");
            $photoPath = $file->storeAs('/img/uploads', $profile->id.'.png',['disk' => 'public_uploads']);

            $photo = Image::make(public_path("{$photoPath}"))->resize(275, 275);
            $photo->save();

            Auth::user()->update([
                'name' => $request->name,
                'email' => $request->email,
                'image' => $photoPath,
            ]);
            $profile->team->update([
                'user' => $request->name,
            ]);
        }else{
            Auth::user()->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            $profile->team->update([
                'user' => $request->name,
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

    public function do_delete_profile($id)
    {
        $user = User::find($id); // find the user record by ID

        if ($user) {
            // delete the related records in the teams table
            $user->team()->delete();


            // delete the user record
            $user->delete();

            Auth::logout(); // log the user out
            return redirect('/')->withSuccess('Your profile has been deleted.');
        } else {
            return redirect('/manager/profile')->withErrors('Could not delete profile. Please try again.');
        }
    }

    public function room()
    {
        $title = 'Meetings';
        $team_leader = Team::where('user', Auth::user()->name)->first();
        $meetings = Meeting::where('created_by', $team_leader->created_by)->get();

        return view('user.meeting',['title' => $title, 'meetings' => $meetings]);
    }

    public function join()
    {
        $title = 'Meetings';
        $meetings = Meeting::all();
        return view('user.join',['title' => $title, 'meetings' => $meetings]);
    }

    public function join_meeting(Request $request){

        $request->validate([
            'meeting_id' => 'required',
            'password' => 'nullable',

        ]);

        $meeting = Meeting::where('meeting_id', $request->meeting_id)->first();

        if (!$meeting) {
            // Store the last tried meeting_id in session
            $request->session()->flash('last_meeting_id', $request->meeting_id);

            return redirect()->back()->withErrors('No meeting with that name exists!')->withInput();
        } else{
            return redirect()->route('room', ['meeting_id' => $request->meeting_id]);
        }
    }
}
