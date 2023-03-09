<?php

namespace App\Providers;

use App\Models\GoogleSettings;
use Illuminate\Support\ServiceProvider;
use Config;

class GoogleProvider extends ServiceProvider
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
        $googleSettings = GoogleSettings::first();
        if ($googleSettings) {
            $filePath = storage_path("app/storage/{$googleSettings->service_account}");

            $data = [
                'client_id' => $googleSettings->google_client_id,
                'client_secret' => $googleSettings->google_client_secret,
                'scopes' => [\Google\Service\Sheets::DRIVE, \Google\Service\Sheets::SPREADSHEETS],
                'access_type' => 'online',
                'approval_prompt' => 'auto',
                'service' => [
                    'enable' => true,
                    'file' => $filePath,
                ]
            ];
            Config::set('google', $data);

        }
    }
}
