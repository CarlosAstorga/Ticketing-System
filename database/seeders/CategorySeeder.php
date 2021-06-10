<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['title' => 'Bugs / Errores']);
        Category::create(['title' => 'Nueva característica']);
        Category::create(['title' => 'Otro']);
    }
}
