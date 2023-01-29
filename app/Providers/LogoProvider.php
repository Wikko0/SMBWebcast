<?php

namespace App\Providers;

use App\Models\LogoSettings;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class LogoProvider extends ServiceProvider
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
        $logo = cache()->remember(
            key:'logo',
            ttl:3600,
            callback: fn() => LogoSettings::all()->keyBy('key')
        );
        View::share('logo', $logo);
    }
}
