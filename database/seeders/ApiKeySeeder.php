<?php

namespace Database\Seeders;

use App\Models\ApiKey;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApiKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ApiKey::create([
            'apiurl' => '/api/v1',
            'apikey' => 'a94jwdbe8wx7pcdogqivoki8',
        ]);
    }
}
