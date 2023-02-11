<?php

namespace App\Http\Controllers;

use App\Models\ApiSettings;
use App\Models\GoogleSettings;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use Sheets;

class PlugnPaidController extends Controller
{
    public function index(){
        $api = ApiSettings::first();
        $response = Http::withToken($api->plugnpaid_api)
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

        $sheets = GoogleSettings::first();
        $header = ['Name', 'Email', 'Country', 'Team Name'];
        $sheet = Sheets::spreadsheet($sheets->spreadsheet)->sheet($sheets->sheet_name);
        $firstRow = $sheet->get();

        if (count($firstRow) > 0) {
            $firstRow = $firstRow[0];
            $diff = array_diff($header, $firstRow);

            if (!empty($diff)) {
                $sheet->update([$header], 'RAW');
            }
        } else {
            $sheet->update([$header]);
        }

        Sheets::spreadsheet($sheets->spreadsheet)->sheet($sheets->sheet_name)->append([
            [$last_customer['name'], $last_customer['email'], $last_customer['country'], $teamname],
        ]);

        Mail::to($last_customer['email'])->send(new WelcomeMail());

        return redirect('/')->withSuccess('You have registered successfully!');
    }

}
