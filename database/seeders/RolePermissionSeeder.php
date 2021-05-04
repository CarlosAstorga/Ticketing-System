<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::all()->pluck('id');

        Role::find(1)->permissions()->sync($permissions);

        // Role::all()->each(function ($role) use ($permissions) {
        //     $role->permissions()->attach(
        //         $permissions->random(1)->pluck('id')
        //     );
        // });
    }
}
