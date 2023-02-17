<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use App\Models\Common;
use App\Models\Meeting;
use App\Models\NotificationSend;
use App\Models\NotificationSettings;
use App\Models\NotificationTeams;
use App\Models\Settings;
use App\Models\Team;
use App\Models\User;
use App\Models\Webhook;
use App\Rules\MatchOldPassword;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class ManagerController extends Controller
{
    public function dashboard()
    {
        $title = 'Dashboard';



        $today = Carbon::today();
        $hostToday = Meeting::where('created_by', Auth::user()->name)->whereDate('created_at', $today)->count();
        $joinedToday = Meeting::where('created_by', Auth::user()->name)->whereDate('created_at', $today)->sum('joined');
        $userRegister = Auth::user()->team->where('created_by', Auth::user()->name)->count('user');
        $userRegisterToday = Auth::user()->team->where('created_by', Auth::user()->name)->whereDate('created_at', $today)->count('user');
        $commonModel = new Common();
        $getDay = $commonModel->get_days_of_this_month();
        $joined = $commonModel->joined_meeting_this_month_chart_data_team();
        $hosted = $commonModel->hosted_meeting_this_month_chart_data_team();
        $yearlyJoined = $commonModel->yearly_join_meeting_chart_data_team();
        $yearlyHosted = $commonModel->yearly_host_meeting_chart_data_team();
        return view('manager.dashboard', [
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
        $team = Auth::user()->team;
        $billing = Webhook::where('payer_email', Auth::user()->email)->first();
        $expires =  $billing->end_time - $billing->start_time;
        if ($expires <= 0){
            $time = 'Expired';
        }else
        {
            $time = date("Y-m-d H:i:s", $billing->end_time);
        }
        return view('manager.profile', ['title' => $title, 'profile' => $profile, 'team' => $team, 'billing' => $billing, 'time' => $time]);
    }

    public function do_profile(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:50','min:3', Rule::unique('users')->ignore($request->id),],
            'email' => ['required', 'email', Rule::unique('users')->ignore($request->id),],
            'team' => 'required',
            'photo' => 'mimes:jpeg,png,jpg,gif'
        ]);

        $profile = Auth::user();

        if ($request->photo)
        {
            $file = $request->file("photo");
            $photoPath = $file->storeAs('/img/uploads', $profile->id.'.png',['disk' => 'public_uploads']);

            $photo = Image::make(public_path("{$photoPath}"))->resize(275, 275);
            $photo->save();

            Webhook::where('payer_email', Auth::user()->email)
                ->update(['payer_email' => $request->email]);

            NotificationTeams::where('manager', Auth::user()->name)
                ->update(['manager' => $request->name]);

            Team::where('created_by', Auth::user()->name)->
            update([
                'created_by' => $request->name,
            ]);

            Meeting::where('created_by', Auth::user()->name)->
            update([
                'created_by' => $request->name,
                'created_by_mail' => $request->email,
            ]);

            Auth::user()->update([
                'name' => $request->name,
                'email' => $request->email,
                'image' => $photoPath,
            ]);


            $profile->team->update([
                'name' => $request->team,
                'user' => $request->name,
                'created_by' => $request->name,
            ]);
        }else{
            Webhook::where('payer_email', Auth::user()->email)
                ->update(['payer_email' => $request->email]);

            NotificationTeams::where('manager', Auth::user()->name)
                ->update(['manager' => $request->name]);

            Team::where('created_by', Auth::user()->name)->
            update([
                'created_by' => $request->name,
            ]);

            Meeting::where('created_by', Auth::user()->name)->
            update([
                'created_by' => $request->name,
                'created_by_mail' => $request->email,
            ]);

            Auth::user()->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $profile->team->update([
                'name' => $request->team,
                'user' => $request->name,
                'created_by' => $request->name,
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
        $check = Webhook::where('payer_email', Auth::user()->email)->first();
        $start_time = $check->start_time;
        $end_time = $check->end_time;
        $difference = $end_time - $start_time;
        $loggedInUserName = Auth::user()->name;
        $users = User::whereHas('team', function ($query) use ($loggedInUserName) {
            $query->where('created_by', $loggedInUserName);
        })->get();
        $search = $request->get('name');
        if ($search)
        {
            $users = User::where('email', 'like', '%'.$search.'%')
                ->whereHas('team', function ($query) use ($loggedInUserName) {
                    $query->where('created_by', $loggedInUserName);
                })
                ->paginate(5);
        }

        return view('manager.manage_user',['title' => $title, 'users' => $users, 'difference' => $difference]);
    }

    public function user_add()
    {
        $title = 'Add Users';
        return view('manager.user_add',['title' => $title]);
    }

    public function do_user_add(Request $request)
    {

        $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8'],
        ]);


            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ])->assignRole('user');
            Team::create([
                'name' => Auth::user()->team->name,
                'user' => $request->name,
                'created_by' => Auth::user()->name,
                'user_id' => $user->id,
            ]);
        Mail::to($request->email)->send(new WelcomeMail());

        return redirect()->back()->withSuccess('You have added this user successfully!');
    }

    public function user_edit($id)
    {
        $title = 'Edit Users';
        $user = User::findOrFail($id);
        $team = Team::where('user', $user->name)->first();
        return view('manager.user_edit',['title' => $title, 'user' => $user, 'team' => $team]);
    }

    public function do_user_edit(Request $request)
    {

        $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($request->id),],
            'password' => ['required', 'min:8'],
        ]);

            $user = User::find($request->id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            $user->assignRole('user');



        return redirect()->back()->withSuccess('You have edited this user successfully!');
    }

    public function user_delete($id)
    {
        $teams = Team::where('user_id', $id)->get();
        foreach ($teams as $team) {
            $team->delete();
        }

        User::where('id', $id)->delete();

        return redirect()->back()->withSuccess('You have deleted this user successfully!');
    }

    public function meetingHistory(Request $request)
    {
        $title = 'Meetings History';
        $check = Webhook::where('payer_email', Auth::user()->email)->first();
        $start_time = $check->start_time;
        $end_time = $check->end_time;
        $difference = $end_time - $start_time;
        $meetings = Meeting::onlyTrashed()->where('created_by', Auth::user()->name)->get();
        $search = $request->get('meeting_code');
        if ($search)
        {
            $meetings = Meeting::where('title', 'like', '%'.$search.'%')->paginate(5);
        }
        return view('manager.meeting_history',['title' => $title, 'meetings' => $meetings, 'difference' => $difference]);
    }

    public function meeting(Request $request)
    {
        $title = 'Meetings';
        $check = Webhook::where('payer_email', Auth::user()->email)->first();
        $start_time = $check->start_time;
        $end_time = $check->end_time;
        $difference = $end_time - $start_time;
        $meetings = Meeting::where('created_by', Auth::user()->name)->get();
        $search = $request->get('meeting_code');
        if ($search)
        {
            $meetings = Meeting::where('title', 'like', '%'.$search.'%')->paginate(5);
        }
        return view('manager.meeting',['title' => $title, 'meetings' => $meetings, 'difference' => $difference]);
    }

    public function meeting_add()
    {
        $title = 'Add Meeting';
        return view('manager.meeting_add',['title' => $title]);
    }

    public function do_meeting_add(Request $request)
    {

        $request->validate([
            'title' => ['required', 'min:3'],
            'meeting_id' => ['required', 'unique:meetings,meeting_id', 'regex:/^\S*$/u'],

        ]);

        $user = Auth::user()->name;
        $email = Auth::user()->email;
        $settings = Settings::first();
        $notification = NotificationTeams::where('manager', Auth::user()->name)->first();
        if ($request->password)
        {
            Meeting::create([
                'title' => $request->title,
                'meeting_id' => $settings->meeting_id.$request->meeting_id,
                'created_by' => $user,
                'created_by_mail' => $email,
                'password' => $request->password,
                'app_id' => $notification->app_id,
            ]);
        }else{
            Meeting::create([
                'title' => $request->title,
                'meeting_id' => $settings->meeting_id.$request->meeting_id,
                'created_by' => $user,
                'created_by_mail' => $email,
                'app_id' => $notification->app_id,
            ]);
        }


        return redirect()->back()->withSuccess('You have added this meeting successfully!');
    }

    public function meeting_edit($id)
    {
        $title = 'Edit Meeting';
        $meeting = Meeting::findOrFail($id);
        return view('manager.meeting_edit',['title' => $title, 'meeting' => $meeting]);
    }

    public function do_meeting_edit(Request $request)
    {

        $request->validate([
            'title' => ['required', 'min:3'],
            'meeting_id' => ['required','regex:/^\S*$/u', Rule::unique('meetings')->ignore($request->id)],
        ]);

        if ($request->password){
            Meeting::where('id',$request->id)
                ->update([
                    'title' => $request->title,
                    'meeting_id' => $request->meeting_id,
                    'password' => $request->password,
                ]);
        }else{
            Meeting::where('id',$request->id)
                ->update([
                    'title' => $request->title,
                    'meeting_id' => $request->meeting_id,
                ]);
        }


        return redirect()->back()->withSuccess('You have edited this meeting successfully!');
    }

    public function meeting_delete($id)
    {
        Meeting::where('id', $id)->delete();

        return redirect()->back()->withSuccess('You have deleted this meeting successfully!');
    }

    public function room()
    {
        $title = 'Meetings';
        $meetings = Meeting::all();

        return view('manager.join',['title' => $title, 'meetings' => $meetings]);
    }

    public function notificationSettings()
    {
        $title = 'Notification Setting';
        $notificationSettings = NotificationTeams::where('manager', Auth::user()->name)->first();
        return view('manager.notification-settings',['title' => $title, 'notificationSettings' => $notificationSettings]);
    }

    public function do_notificationSettings(Request $request)
    {
        $request->validate([
            'app_id' => 'required',
        ]);

        NotificationTeams::where('manager', $request->manager)
            ->update([
                'app_id' => $request->app_id,
                'authorize' => $request->authorize,
            ]);

        return redirect()->back()->withSuccess('You have changed this settings successfully!');
    }

    public function notificationSend()
    {
        $title = 'Notification Send';

        return view('manager.notification-send',['title' => $title]);
    }

    public function do_notificationSend(Request $request)
    {
        $request->validate([
            'heading' => 'required',
            'title' => 'required',
            'url' => 'required|url',
            'icon_url' => 'required|url',
            'image_url' => 'required|url',
        ]);


        NotificationSend::create([
            'heading' => $request->title,
            'content' => $request->title,
            'url' => $request->url,
            'icon' => $request->icon_url,
            'image' => $request->image_url,
        ]);


        $settings = NotificationSettings::first();
        $data = NotificationSend::latest()
            ->first();;

        $client = new \GuzzleHttp\Client();
        $body ='{"app_id":"'.$settings->app_id.'",
            "included_segments":["All"],
            "url":"'.$data->url.'",
            "chrome_web_icon":"'.$data->icon.'",
            "chrome_web_image":"'.$data->image.'",
            "big_picture":"'.$data->image.'",
            "small_icon":"'.$data->icon.'",
            "large_icon":"'.$data->icon.'",
            "contents":{"en":"'.$data->content.'"},
            "headings":{"en":"'.$data->heading.'"},
            "name":"INTERNAL_CAMPAIGN_NAME"}';
        $response = $client->request('POST', 'https://onesignal.com/api/v1/notifications', [
            'body' => $body,
            'headers' => [
                'Authorization' => 'Basic '.$settings->authorize,
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ],
        ]);

        echo $response->getBody();

        return redirect()->back()->withSuccess('You have push this OneSignal successfully!');
    }

    public function join(Request $request){

        $request->validate([
            'meeting_id' => 'required',
            'password' => 'nullable',

        ]);

        $meeting = Meeting::where('meeting_id', $request->meeting_id)->first();

        if (!$meeting) {
            // Store the last tried meeting_id in session
            $request->session()->flash('last_meeting_id', $request->meeting_id);

            return redirect()->back()->withErrors('No meeting with that name exists!')->withInput();
        }

        if (!empty($meeting->password))
        {

            if ($meeting->password == $request->password){

                return redirect()->route('room', ['meeting_id' => $request->meeting_id]);
            }else{
                // Store the last tried meeting_id in session
                $request->session()->flash('last_meeting_id', $request->meeting_id);

                return redirect()->back()->withErrors('Wrong Password!')->withInput();
            }
        }else{
            return redirect()->route('room', ['meeting_id' => $request->meeting_id]);
        }
    }
}
