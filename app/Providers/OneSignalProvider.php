<?php

namespace App\Providers;

use App\Models\NotificationTeams;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class OneSignalProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view)
        {
            if (Auth::check()){
                $manager = Auth::user()->team->created_by_mail;
                $oneSignalTeam = NotificationTeams::where('manager', $manager)->first();

                //...with this variable
                $view->with('oneSignalTeam', $oneSignalTeam );
            }

        });
    }
}
