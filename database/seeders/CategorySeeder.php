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
        Category::create(['title' => 'Retroalimentación']);
        Category::create(['title' => 'Nueva función']);
        Category::create(['title' => 'Otro']);
    }
}
