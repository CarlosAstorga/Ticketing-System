<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['title' => 'Administrador']);
        Role::create(['title' => 'Lider de proyecto']);
        Role::create(['title' => 'Desarrollador']);
        Role::create(['title' => 'Usuario']);
    }
}
