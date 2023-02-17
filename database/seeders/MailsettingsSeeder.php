<?php

namespace Database\Seeders;


use App\Models\MailSettings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MailsettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MailSettings::create([
            'from_name' => 'SMB Webcast',
            'mail_transport' => 'smtp',
            'mail_host' => 'smtp.mailtrap.io',
            'mail_port' => '2525',
            'mail_username' => '33bea009ce41f4',
            'mail_password' => 'e431f6aff6b8fc',
            'mail_encryption' => 'tls',
            'mail_from' => 'victor.minchew@gmail.com',
        ]);
    }
}
