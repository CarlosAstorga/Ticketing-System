<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create(['title' => 'Abierto']);
        Status::create(['title' => 'Pendiente']);
        Status::create(['title' => 'Resuelto']);
        Status::create(['title' => 'Cerrado']);
    }
}
