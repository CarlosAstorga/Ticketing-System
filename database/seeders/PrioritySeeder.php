<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Priority::create(['title' => 'Baja']);
        Priority::create(['title' => 'Media']);
        Priority::create(['title' => 'Alta']);
    }
}
