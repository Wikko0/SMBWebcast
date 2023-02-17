<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\Model;
use App\Models\Team;
use App\Models\User;
use App\Models\Webhook;

class ApiController extends Controller
{
    public function index()
    {
        $models = [
            'Users' => User::all(),
            'Teams' => Team::all(),
            'Meetings' => Meeting::all(),
            'Webhook' => Webhook::all(),
        ];
        return response()->json($models);
    }
}
