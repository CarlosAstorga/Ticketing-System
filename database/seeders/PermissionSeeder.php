<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['title' => 'user_management_access']);
        Permission::create(['title' => 'user_create']);
        Permission::create(['title' => 'user_edit']);
        Permission::create(['title' => 'user_show']);
        Permission::create(['title' => 'user_delete']);
        Permission::create(['title' => 'user_access']);
        Permission::create(['title' => 'user_assigment']);
        Permission::create(['title' => 'project_create']);
        Permission::create(['title' => 'project_edit']);
        Permission::create(['title' => 'project_show']);
        Permission::create(['title' => 'project_delete']);
        Permission::create(['title' => 'project_access']);
        Permission::create(['title' => 'ticket_create']);
        Permission::create(['title' => 'ticket_edit']);
        Permission::create(['title' => 'ticket_show']);
        Permission::create(['title' => 'ticket_delete']);
        Permission::create(['title' => 'ticket_access']);
        Permission::create(['title' => 'ticket_close']);
        Permission::create(['title' => 'ticket_resolve']);
    }
}
