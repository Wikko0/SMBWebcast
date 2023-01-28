<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::create([
            'key' => 'settings',
            'app_name' => 'SMBWebcast',
            'jitsi_url' => 'https://meet.jit.si/',
            'policy_url' => 'https://live.smbwebcast.com/privacy-policy/',
            'meeting_id' => 'MEETING-',
        ]);
    }
}
