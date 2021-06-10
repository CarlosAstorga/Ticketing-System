<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'name'              => 'Administrador',
            'email'             => 'admin@tsystem.com',
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10),
            'email_verified_at' => now()
        ];

        User::create($data);
        User::factory()->times(10)->create();
        Storage::deleteDirectory('/public/images/avatar/');
        Storage::deleteDirectory('/public/images/tickets/');
    }
}
