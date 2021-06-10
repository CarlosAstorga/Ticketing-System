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
        $roles              = Role::all();
        $permissions        = Permission::all();

        $roles->each(function($role) use($permissions) {
            switch ($role->id) {
                case 1:
                    $ids    = $permissions;
                    break;
                case 2:
                    $ids    = $permissions->filter(function($permission) {
                        return $permission->id == 6 || $permission->module_id > 3;
                    });
                    break;
                case 3:
                    $ids    = $permissions->filter(function($permission) {
                        return $permission->module_id == 5 && $permission->id != 23;
                    });
                    break;
                default:
                    $ids    = $permissions->filter(function($permission) {
                        return $permission->module_id == 5 && $permission->id != 20 && $permission->id != 22 && $permission->id != 23;
                    });
                    break;
            }
            $role->permissions()->sync($ids->pluck('id'));
        });

        // Role::all()->each(function ($role) use ($permissions) {
        //     $role->permissions()->attach(
        //         $permissions->random(1)->pluck('id')
        //     );
        // });
    }
}
