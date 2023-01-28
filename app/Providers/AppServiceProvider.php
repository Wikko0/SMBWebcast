<?php

namespace App\Providers;

use App\Models\Settings;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $settings = cache()->remember(
            key:'settings',
            ttl:3600,
            callback: fn() => Settings::all()->keyBy('key')
        );
        View::share('settings', $settings);
    }
}
