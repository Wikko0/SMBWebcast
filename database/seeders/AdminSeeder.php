<?php

namespace Database\Seeders;

use App\Models\NotificationTeams;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => Str::random(10),
        ]);

        $user->assignRole('admin');

        Team::create([
            'name' => 'Admin Team',
            'user' => 'admin',
            'created_by' => 'admin',
            'created_by_mail' => 'admin@gmail.com',
            'user_id' => $user->id,
        ]);

        NotificationTeams::create([
            'app_id' => 'f13077fb-f4c9-4af9-9766-584d939466b7',
            'authorize' => 'YWE2OWU3Y2ItMDEwZS00N2JjLWJmNDYtYzllMjA3OWJmMGRi',
            'manager' => $user->email
        ]);
    }
}
