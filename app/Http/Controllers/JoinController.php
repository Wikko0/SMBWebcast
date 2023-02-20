<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Joined;
use App\Models\Meeting;
use App\Models\Team;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JoinController extends Controller
{
    public function room($id){
        $last_meeting_id = session('last_meeting_id');

        if ($last_meeting_id) {
            // If there was a last meeting_id, use it
            $meeting = Meeting::where('meeting_id', $last_meeting_id)->first();

            if (!$meeting) {
                return redirect()->back()->withErrors('No meeting with that name exists!');
            }
        } else {
            $meeting = Meeting::where('meeting_id', $id)->first();
        }
        $teamName = Team::where('user', $meeting->created_by)->first();
        $team = Team::where('name', $teamName->name)->get(['user']);
        $user = Auth::user();

        $active = false;
        foreach ($team as $key => $teamMember) {
            $check = User::where('name', $teamMember->user)->first();
            if ($check->last_activity > now()->subMinutes(120)) {
                $active = true;
                break;
            }
        }

        if ($active) {
            Meeting::where('meeting_id', $id)->update(['joined' => Meeting::raw('joined+1')]);
            Joined::create([
                'name' => Auth::user()->name ?? 'Guest',
                'meeting_id' => $meeting->meeting_id
            ]);
            return view('room', ['meeting' => $meeting, 'user' => $user]);
        } else {
            session()->flash('last_meeting_id', $last_meeting_id);
            return redirect()->back()->withErrors('The moderator has not yet entered the event!')->withInput();
        }
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
