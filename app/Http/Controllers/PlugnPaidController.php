<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class PlugnPaidController extends Controller
{
    public function index(){
        $response = Http::withToken("b02591f5-71e3-4a97-a4c0-8f7f2fcfb96e")
            ->get('https://api.plugnpaid.com/v1/customers/list');

        $customers = $response['customers'];
        $last_customer = end($customers);

        $user = User::firstOrNew(['email' => $last_customer['email']]);
        $user->name = $last_customer['name'];
        $user->email = $last_customer['email'];
        $user->password = Hash::make($last_customer['name']);
        $user->save();
        $user->assignRole('manager');

        $team = Team::firstOrNew(['user_id' => $user->id]);
        $team->name = 'Team Name';
        $team->user = $last_customer['name'];
        $team->created_by = $last_customer['name'];
        $team->user_id = $user->id;
        $team->save();

        return redirect('/')->withSuccess('You have registered successfully!');
    }
}
