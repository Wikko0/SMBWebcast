<?php

namespace Database\Seeders;

use App\Models\NotificationSettings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NotificationSettings::create([
           'app_id' => 'f13077fb-f4c9-4af9-9766-584d939466b7',
           'authorize' => 'ZjA0NjQyNmUtNDRlYi00MjE1LTkzYTMtODcwZDdmZmIxYjkx',
           'auth_key' => 'MjI4Nzc4ODMtNjE5Yy00NzExLTlkZWEtOTJmNDlmZjc3MjZls',
        ]);
    }
}
