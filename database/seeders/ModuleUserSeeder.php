<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\User;
use Illuminate\Database\Seeder;

class ModuleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $modules = Module::all();

        User::all()->each(function ($user) use ($modules) {
            $user->modules()->attach(
                $modules->random(1)->pluck('id')
            );
        });
    }
}
