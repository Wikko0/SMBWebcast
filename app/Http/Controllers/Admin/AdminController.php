<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use App\Models\ApiSettings;
use App\Models\Common;
use App\Models\GoogleSettings;
use App\Models\LogoSettings;
use App\Models\MailSettings;
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
use Spatie\FlareClient\Api;
use Sheets;

class AdminController extends Controller
{

    public function dashboard()
    {
        $title = 'Dashboard';

        $today = Carbon::today();
        $hostToday = Meeting::whereDate('created_at', $today)->count();
        $joinedToday = Meeting::whereDate('created_at', $today)->sum('joined');
        $userRegister = User::count();
        $userRegisterToday = User::whereDate('created_at', $today)->count();
        $commonModel = new Common();
        $getDay = $commonModel->get_days_of_this_month();
        $joined = $commonModel->joined_meeting_this_month_chart_data();
        $hosted = $commonModel->hosted_meeting_this_month_chart_data();
        $yearlyJoined = $commonModel->yearly_join_meeting_chart_data();
        $yearlyHosted = $commonModel->yearly_host_meeting_chart_data();
        return view('admin.dashboard', [
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
        return view('admin.profile', ['title' => $title, 'profile' => $profile]);
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
        $users = User::with('roles')->get();
        $search = $request->get('name');
        if ($search)
        {
            $users = User::where('email', 'like', '%'.$search.'%')->with('roles')->paginate(5);
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
            'team' => ['required'],
            'role' => ['required'],
        ]);

        if ($request->role == 'user')
        {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ])->assignRole('user');
            Team::create([
                'name' => $request->team,
                'user' => $request->name,
                'created_by' => Auth::user()->name,
                'user_id' => $user->id,
            ]);
            Mail::to($request->email)->send(new WelcomeMail());
        }

        if ($request->role == 'manager')
        {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ])->assignRole('manager');
            Team::create([
                'name' => $request->team,
                'user' => $request->name,
                'created_by' => Auth::user()->name,
                'user_id' => $user->id,
            ]);
            $startTime = time();
            $endTime = strtotime("1 Year");
            Webhook::create([
                'product_name' => 'Added by Admin',
                'product_price' => '0',
                'currency' => 'EUR',
                'payment_method' => 'Admin',
                'cancellation_link' => '.',
                'status' => 'Paid',
                'start_time' => $startTime,
                'end_time' => $endTime,
                'payer_email' => $request->email,
            ]);
            NotificationTeams::create([
                'app_id' => 'f13077fb-f4c9-4af9-9766-584d939466b7',
                'authorize' => 'YWE2OWU3Y2ItMDEwZS00N2JjLWJmNDYtYzllMjA3OWJmMGRi',
                'manager' => $request->name
            ]);

            Mail::to($request->email)->send(new WelcomeMail());
        }

        if ($request->role == 'admin')
        {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ])->assignRole('admin');
            Team::create([
                'name' => $request->team,
                'user' => $request->name,
                'created_by' => Auth::user()->name,
                'user_id' => $user->id,
            ]);
            NotificationTeams::create([
                'app_id' => 'f13077fb-f4c9-4af9-9766-584d939466b7',
                'authorize' => 'YWE2OWU3Y2ItMDEwZS00N2JjLWJmNDYtYzllMjA3OWJmMGRi',
                'manager' => $request->name
            ]);
            Mail::to($request->email)->send(new WelcomeMail());
        }
        return redirect()->back()->withSuccess('You have added this user successfully!');
    }

    public function user_edit($id)
    {
        $title = 'Edit Users';
        $user = User::findOrFail($id);
        $team = Team::where('user', $user->name)->first();
        return view('admin.user_edit',['title' => $title, 'user' => $user, 'team' => $team]);
    }

    public function do_user_edit(Request $request)
    {

        $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($request->id),],
            'password' => ['required', 'min:8'],
            'team' => ['required'],
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

            Team::where('user', $user->name)->update([
                'name' => $request->team
                ]
            );

        }

        if ($request->role == 'manager')
        {

            $user = User::find($request->id);
            Webhook::where('payer_email', $user->email)
                ->update(['payer_email' => $request->email]);

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            $user->assignRole('manager');


            Team::where('user', $user->name)->update([
                    'name' => $request->team
                ]
            );
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

            Team::where('user', $user->name)->update([
                    'name' => $request->team
                ]
            );
        }
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

    public function settings()
    {
        $title = 'System Setting';

        return view('admin.settings',['title' => $title]);
    }

    public function do_settings(Request $request)
    {
        $request->validate([
            'app_name' => ['required', 'max:40'],
            'jitsi_url' => ['required', 'url'],
            'meeting_prefix' => ['required'],
        ]);

        Settings::where('key', 'settings')
        ->update([
        'app_name' => $request->app_name,
        'jitsi_url' => $request->jitsi_url,
        'meeting_id' => $request->meeting_prefix,
        'address' => $request->address,
        'phone' => $request->phone,
        'policy' => $request->policy_text,
        ]);

        return redirect()->back()->withSuccess('You have changed this settings successfully!');
    }

    public function emailSettings()
    {
        $title = 'Email Setting';
        $mailSettings = MailSettings::first();
        return view('admin.email-settings',['title' => $title, 'mailSettings' => $mailSettings]);
    }

    public function do_emailSettings(Request $request)
    {
        $request->validate([
            'transport' => 'required',
            'host' => 'required',
            'port' => 'required',
            'username' => 'required',
            'password' => 'required',
            'encryption' => 'required',
            'from' => 'required',

        ]);

        MailSettings::where('id', $request->id)
            ->update([
                'mail_transport' => $request->transport,
                'mail_host' => $request->host,
                'mail_port' => $request->port,
                'mail_username' => $request->username,
                'mail_password' => $request->password,
                'mail_encryption' => $request->encryption,
                'mail_from' => $request->from,
            ]);

        return redirect()->back()->withSuccess('You have changed this settings successfully!');
    }

    public function logoSettings()
    {
        $title = 'Logo & Image Setting';
        $images = LogoSettings::first();
        return view('admin.logo-settings',['title' => $title, 'images' => $images]);
    }

    public function do_logoSettings(Request $request)
    {
        $this->validate($request, [
            'logo' => 'image',
            'image' => 'image',
            'favicon' => 'image',

        ]);

            $logoCheck = LogoSettings::first();

            if ($request->logo){
                $logoPath = $request->logo->storeAs('uploads', 'logo.png', "public");
                $logo = Image::make(public_path("storage/{$logoPath}"))->resize(80, 80);
                $logo->save();
            }else {
                if (!empty($logoCheck->logo)){
                    $logoPath = $logoCheck->logo;
                }
            }

            if ($request->image){
                $imagePath = $request->image->storeAs('uploads', 'login-bg.jpg', "public");
                $image = Image::make(public_path("storage/{$imagePath}"))->resize(640, 440);
                $image->save();

            }else {
                if (!empty($logoCheck->image)){
                    $imagePath = $logoCheck->image;
                }
            }

            if ($request->favicon)
            {
                $favPath = $request->favicon->storeAs('uploads', 'favicon.png', "public");
                $fav = Image::make(public_path("storage/{$favPath}"))->resize(16, 16);
                $fav->save();
            }else {
                if (!empty($logoCheck->favicon)){
                    $favPath = $logoCheck->favicon;
                }
            }


            if ($logoCheck){
                LogoSettings::where('key', 'logo')->update([
                    'logo' =>  $logoPath??'',
                    'image' =>  $imagePath??'',
                    'favicon' =>  $favPath??'',
                ]);
                return redirect()->back()->withSuccess('You have changed this images successfully!');
            }else{
                LogoSettings::insert([
                    'logo' =>  $logoPath??'',
                    'image' =>  $imagePath??'',
                    'favicon' =>  $favPath??'',
                ]);
                return redirect()->back()->withSuccess('You have added this images successfully!');
            }

    }

    public function apiSettings()
    {
        $title = 'API Setting';
        $api = ApiSettings::first();
        $google = GoogleSettings::first();
        return view('admin.api-settings',['title' => $title, 'api' => $api, 'google' => $google]);
    }

    public function do_apiSettings(Request $request)
    {
        $request->validate([
            'plugnpaid_api' => 'required',

        ]);

        ApiSettings::where('id', $request->id)
            ->update([
                'plugnpaid_api' => $request->plugnpaid_api,
            ]);

        return redirect()->back()->withSuccess('You have changed this settings successfully!');
    }

    public function do_apiGoogle(Request $request)
    {
        $request->validate([
            'google_client_id' => 'required',
            'google_client_secret' => 'required',
            'spreadsheet' => 'required',
            'sheet_name' => 'required',

        ]);

        GoogleSettings::where('id', $request->id)
            ->update([
                'google_client_id' => $request->google_client_id,
                'google_client_secret' => $request->google_client_secret,
                'spreadsheet' => $request->spreadsheet,
                'sheet_name' => $request->sheet_name,
            ]);

        return redirect()->back()->withSuccess('You have changed this settings successfully!');
    }

    public function meetingHistory(Request $request)
    {
        $title = 'Meetings History';
        $meetings = Meeting::onlyTrashed()->get();
        $search = $request->get('meeting_code');
        if ($search)
        {
            $meetings = Meeting::where('title', 'like', '%'.$search.'%')->paginate(5);
        }
        return view('admin.meeting_history',['title' => $title, 'meetings' => $meetings]);
    }

    public function meeting(Request $request)
    {
        $title = 'Meetings';
        $meetings = Meeting::all();
        $search = $request->get('meeting_code');
        if ($search)
        {
            $meetings = Meeting::where('title', 'like', '%'.$search.'%')->paginate(5);
        }
        return view('admin.meeting',['title' => $title, 'meetings' => $meetings]);
    }

    public function meeting_add()
    {
        $title = 'Add Meeting';
        return view('admin.meeting_add',['title' => $title]);
    }

    public function do_meeting_add(Request $request)
    {

        $request->validate([
            'title' => ['required', 'min:3'],
            'meeting_id' => ['required', 'unique:meetings,meeting_id', 'regex:/^\S*$/u']
        ]);

        $user = Auth::user()->name;
        $settings = Settings::first();
        $notification = NotificationSettings::first();
        if ($request->password)
        {
            Meeting::create([
                'title' => $request->title,
                'meeting_id' => $settings->meeting_id.$request->meeting_id,
                'created_by' => $user,
                'password' => $request->password,
                'app_id' => $notification->app_id,
            ]);
        }else{
            Meeting::create([
                'title' => $request->title,
                'meeting_id' => $settings->meeting_id.$request->meeting_id,
                'created_by' => $user,
                'app_id' => $notification->app_id,
            ]);
        }

        return redirect()->back()->withSuccess('You have added this meeting successfully!');
    }

    public function meeting_edit($id)
    {
        $title = 'Edit Meeting';
        $meeting = Meeting::findOrFail($id);
        return view('admin.meeting_edit',['title' => $title, 'meeting' => $meeting]);
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


    public function notificationSettings()
    {
        $title = 'Notification Setting';
        $notificationSettings = NotificationSettings::first();
        return view('admin.notification-settings',['title' => $title, 'notificationSettings' => $notificationSettings]);
    }

    public function do_notificationSettings(Request $request)
    {
        $request->validate([
            'app_id' => 'required',
            'authorize' => 'required',
            'auth_key' => 'required',

        ]);

        NotificationSettings::where('id', $request->id)
            ->update([
                'app_id' => $request->app_id,
                'authorize' => $request->authorize,
                'auth_key' => $request->auth_key,
            ]);

        return redirect()->back()->withSuccess('You have changed this settings successfully!');
    }

    public function notificationSend()
    {
        $title = 'Notification Send';

        return view('admin.notification-send',['title' => $title]);
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

    public function room()
    {
        $title = 'Meetings';
        $meetings = Meeting::all();

        return view('admin.join',['title' => $title, 'meetings' => $meetings]);
    }

    public function join(Request $request){

            return redirect()->route('room', ['meeting_id' => $request->meeting_id]);

    }
}
