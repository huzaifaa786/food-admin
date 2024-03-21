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
            ['name' => 'Chinese' ,'image' => 'images/categories/cat2.png'],
            ['name' => 'Brazilian' ,'image' => 'images/categories/cat3.png'],
            ['name' => 'Italian' ,'image' => 'images/categories/cat1.png'],
            ['name' => 'Egyption' ,'image' => 'images/categories/cat3.png'],
            ['name' => 'Japanese' ,'image' => 'images/categories/2.png'],
            ['name' => 'Lebanese' ,'image' => 'images/categories/cat1.png'],
            ['name' => 'Lebanese' ,'image' => 'images/categories/1.png'],
            ['name' => 'American' ,'image' => 'images/categories/cat1.png'],
            ['name' => 'Arabian' ,'image' => 'images/categories/cat3.png'],
            ['name' => 'Greek' ,'image' => 'images/categories/cat2.png'],
            ['name' => 'Asian' ,'image' => 'images/categories/cat2.png'],
        ]);
    }
}
