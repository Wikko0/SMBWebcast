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
    public function room($id)
    {
        $last_meeting_id = session('last_meeting_id')??$id;
        cookie()->queue('last_meeting_id', $last_meeting_id, 60 * 24 * 7); // Cookie expires after 1 week
        if ($last_meeting_id) {
            // If there was a last meeting_id, use it
            $meeting = Meeting::where('meeting_id', $last_meeting_id)->first();

            if (!$meeting) {
                return redirect()->route('room.error')->withErrors('No meeting with that name exists!');
            }
        } else {
            $meeting = Meeting::where('meeting_id', $id)->first();
        }
        $teamName = Team::where('user', $meeting->created_by)->first();
        $team = Team::where('name', $teamName->name)->get(['user']);
        $user = Auth::user();

        // Check password
        $password = session('meeting_password');
        if (!empty($meeting->password)) {
            if ($password !== $meeting->password) {
                session()->flash('last_meeting_id', $last_meeting_id);
                return redirect()->route('room.error')->withErrors('Wrong password!')->withInput();
            } else {
                // Set cookie if password is correct
                cookie()->queue('meeting_password', $password, 60 * 24 * 7); // Cookie expires after 1 week
            }
        }

        $active = false;
        $inTeam = false;
        foreach ($team as $key => $teamMember) {
            $check = User::where('name', $teamMember->user)->first();

            foreach ($team as $teamMemb)
            {
                if (isset($user->name) && $user->name == $teamMemb->user)
                {
                    $inTeam = true;
                    break;
                }
            }


            if ($check->last_activity > now()->subMinutes(120) && $meeting->last_activity > now()->subMinutes(120)) {
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
            // Set cookie if meeting is correct


                return view('room', ['meeting' => $meeting, 'user' => $user, 'inTeam' => $inTeam]);



        } else {
            session()->flash('last_meeting_id', $last_meeting_id);
            return redirect()->route('room.error')->withErrors('The moderator has not yet entered the event!')->withInput();
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

            return redirect()->route('room.error')->withErrors('No meeting with that name exists!')->withInput();
        }
        $request->session()->put('meeting_password', $request->password);

        return $this->room($request->meeting_id);
    }

    public function webhook(){
        return 'Accepted';
    }

    public function roomError(){
        return view('errors.room');
    }
}
