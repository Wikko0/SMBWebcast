<?php

namespace Database\Seeders;


use App\Models\ApiKey;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(RoleSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(MailsettingsSeeder::class);
        $this->call(NotificationSeeder::class);
        $this->call(ApisettingsSeeder::class);
        $this->call(GoogleSeeder::class);
        $this->call(ApiKeySeeder::class);

    }
}
