<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Module::create(['title' => 'Dashboard', 'icon'  => 'fas fa-home']);
        Module::create(['title' => 'Users', 'icon'      => 'fas fa-users']);
        Module::create(['title' => 'Roles', 'icon'      => 'fas fa-tags']);
        Module::create(['title' => 'Projects', 'icon'   => 'fas fa-project-diagram']);
        Module::create(['title' => 'Tickets', 'icon'    => 'fas fa-ticket-alt']);
    }
}
