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
        $logo = LogoSettings::where('key', 'logo')->first();
        View::share('logo', $logo);
    }
}
