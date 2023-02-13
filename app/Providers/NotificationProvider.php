<?php

namespace App\Providers;


use App\Models\NotificationSettings;
use Illuminate\Support\ServiceProvider;
use Config;

class NotificationProvider extends ServiceProvider
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
        $notificationSettings = NotificationSettings::first();
        if ($notificationSettings) {
            $data = [
                'app_id' => $notificationSettings->app_id,
                'authorize' => $notificationSettings->authorize,
                'auth_key' => $notificationSettings->auth_key,
            ];
            Config::set('one-signal', $data);
        }
    }
}
