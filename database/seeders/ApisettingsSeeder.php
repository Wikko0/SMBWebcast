<?php

namespace Database\Seeders;

use App\Models\ApiSettings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApisettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ApiSettings::create([
            'plugnpaid_api' => 'b02591f5-71e3-4a97-a4c0-8f7f2fcfb96e',
        ]);
    }
}
