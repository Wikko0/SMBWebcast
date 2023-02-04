<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Meeting;
use App\Models\Team;
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


    public function room()
    {
        $title = 'Meetings';
        $team_leader = Team::where('user', Auth::user()->name)->first();
        $meetings = Meeting::where('created_by', $team_leader->created_by)->get();

        return view('user.join',['title' => $title, 'meetings' => $meetings]);
    }

    public function join(Request $request){

        $meeting = Meeting::where('meeting_id', $request->meeting_id)->first();
        if (!empty($meeting->password))
        {

            if ($meeting->password == $request->password){

                return redirect()->route('room', ['meeting_id' => $request->meeting_id]);
            }else{
                return redirect()->back()->withErrors('Wrong Password!');
            }
        }else{
            return redirect()->route('room', ['meeting_id' => $request->meeting_id]);
        }

    }
}
