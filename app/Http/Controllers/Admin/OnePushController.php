<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ladumor\OneSignal\OneSignal;

class OnePushController extends Controller
{
    public function push()
    {

        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'https://onesignal.com/api/v1/notifications', [
            'body' => '{"app_id":"f13077fb-f4c9-4af9-9766-584d939466b7",
            "included_segments":["All"],
            "contents":{"en":"English or Any Language Message","es":"Spanish Message"},
            "name":"INTERNAL_CAMPAIGN_NAME"}',
            'headers' => [
                'Authorization' => 'Basic MzU2YWJkZmItZTY4ZC00NDZiLTkwYmQtMGRkNzNkNTIxYWFi',
                'accept' => 'application/json',
                'content-type' => 'application/json',
            ],
        ]);

        echo $response->getBody();
    }
}
