<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JoinController extends Controller
{
    public function room($id){
        $meeting = Meeting::where('meeting_id', $id)->first();
        $user = Auth::user();

        if ($meeting){
            Meeting::where('meeting_id', $id)
                ->update(['joined' => Meeting::raw('joined+1')]);
            return view('room',['meeting' => $meeting, 'user' => $user]);
        }else{
            return redirect()->back()->withErrors('No meeting with that name exists!');
        }

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
