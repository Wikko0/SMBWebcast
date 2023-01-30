<?php

namespace App\Http\Controllers;

use App\Models\NotificationSettings;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
        $onesignal = NotificationSettings::first();
        View::share(['onesignal' => $onesignal]);
    }

}
