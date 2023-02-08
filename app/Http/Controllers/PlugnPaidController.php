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
        $billing_addresses = $last_customer['addresses']['billing'];
        $last_billing_address = end($billing_addresses);
        $custom_billing_fields = $last_billing_address['custom-billing-fields'];

        foreach($custom_billing_fields as $field) {
            if($field['label'] == 'Team Name') {
               $teamname = $field['value'];
            }
            if($field['label'] == 'Account Password') {
                $password = $field['value'];
            }
        }

        $user = User::firstOrNew(['email' => $last_customer['email']]);
        $user->name = $last_customer['name'];
        $user->email = $last_customer['email'];
        $user->password = Hash::make($password);
        $user->save();
        $user->assignRole('manager');

        $team = Team::firstOrNew(['user_id' => $user->id]);
        $team->name = $teamname;
        $team->user = $last_customer['name'];
        $team->created_by = $last_customer['name'];
        $team->user_id = $user->id;
        $team->save();

        return redirect('/')->withSuccess('You have registered successfully!');
    }

}
