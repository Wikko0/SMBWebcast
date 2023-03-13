<?php

namespace App\Providers;

use App\Models\MailSettings;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;
use Config;

class MailProvider extends ServiceProvider
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
        $mailSettings = MailSettings::first();
        if ($mailSettings) {
            $data = [
                'driver' => $mailSettings->mail_transport,
                'host' => $mailSettings->mail_host,
                'port' => $mailSettings->mail_port,
                'encryption' => $mailSettings->mail_encryption,
                'username' => $mailSettings->mail_username,
                'password' => $mailSettings->mail_password,
                'auth_mode'  => null,
                'verify_peer'       => false,
                'from' => [
                    'address' => $mailSettings->mail_from,
                    'name' => 'SMBWebcast']
            ];
            Config::set('mail', $data);
        }
    }
}
