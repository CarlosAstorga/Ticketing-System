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
        Permission::create(['title' => 'user_create', 'module_id' => 2]);
        Permission::create(['title' => 'user_edit', 'module_id' => 2]);
        Permission::create(['title' => 'user_show', 'module_id' => 2]);
        Permission::create(['title' => 'user_delete', 'module_id' => 2]);
        Permission::create(['title' => 'user_access', 'module_id' => 2]);
        Permission::create(['title' => 'user_assigment', 'module_id' => 2]);
        Permission::create(['title' => 'role_create', 'module_id' => 3]);
        Permission::create(['title' => 'role_edit', 'module_id' => 3]);
        Permission::create(['title' => 'role_show', 'module_id' => 3]);
        Permission::create(['title' => 'role_delete', 'module_id' => 3]);
        Permission::create(['title' => 'role_access', 'module_id' => 3]);
        Permission::create(['title' => 'project_create', 'module_id' => 4]);
        Permission::create(['title' => 'project_edit', 'module_id' => 4]);
        Permission::create(['title' => 'project_show', 'module_id' => 4]);
        Permission::create(['title' => 'project_delete', 'module_id' => 4]);
        Permission::create(['title' => 'project_access', 'module_id' => 4]);
        Permission::create(['title' => 'ticket_create', 'module_id' => 5]);
        Permission::create(['title' => 'ticket_edit', 'module_id' => 5]);
        Permission::create(['title' => 'ticket_show', 'module_id' => 5]);
        Permission::create(['title' => 'ticket_delete', 'module_id' => 5]);
        Permission::create(['title' => 'ticket_access', 'module_id' => 5]);
        Permission::create(['title' => 'ticket_close', 'module_id' => 5]);
        Permission::create(['title' => 'ticket_resolve', 'module_id' => 5]);
    }
}
