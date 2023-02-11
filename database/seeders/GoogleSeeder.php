<?php

namespace Database\Seeders;

use App\Models\GoogleSettings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GoogleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GoogleSettings::create([
            'google_client_id' => '963660036843-0s0ut9m38sjkn5h2cihjs7715vqthc1j.apps.googleusercontent.com',
            'google_client_secret' => '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',
            'spreadsheet' => '1iU2T1522saUanWW7Edff-xL9JmWwwbFS8gXVs8vXzfs',
            'sheet_name' => 'PlugnPaid',
        ]);
    }
}
