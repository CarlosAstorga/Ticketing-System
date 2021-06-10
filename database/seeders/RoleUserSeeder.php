<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = Role::all()->except([1]);
        $users = User::all()->except([1]);

        User::find(1)->roles()->attach([1]);
        $users->each(function ($user) use ($roles) {
            $user->roles()->attach(
                $roles->random(1)->pluck('id')
            );
        });
    }
}
