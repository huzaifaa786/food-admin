<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            ['name' => 'Indian' ,'image' => 'images/categories/cat1.png'],
            ['name' => 'Chinese' ,'image' => 'images/categoris/cat2.png'],
            ['name' => 'Brazilian' ,'image' => 'images/categoris/cat3.png'],
            ['name' => 'Italian' ,'image' => 'images/categoris/cat1.png'],
            ['name' => 'Egyption' ,'image' => 'images/categoris/cat3.png'],
            ['name' => 'Japanese' ,'image' => 'images/categoris/2.png'],
            ['name' => 'Lebanese' ,'image' => 'images/categoris/cat1.png'],
            ['name' => 'Lebanese' ,'image' => 'images/categoris/1.png'],
            ['name' => 'American' ,'image' => 'images/categoris/cat1.png'],
            ['name' => 'Arabian' ,'image' => 'images/categoris/cat3.png'],
            ['name' => 'Greek' ,'image' => 'images/categoris/cat2.png'],
            ['name' => 'Asian' ,'image' => 'images/categoris/cat2.png'],
        ]);
    }
}
