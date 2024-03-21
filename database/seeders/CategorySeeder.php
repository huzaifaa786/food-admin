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
            ['name' => 'Indian' ,'image' => 'cat1.png'],
            ['name' => 'Chinese' ,'image' => 'cat2.png'],
            ['name' => 'Brazilian' ,'image' => 'cat3.png'],
            ['name' => 'Italian' ,'image' => 'cat1.png'],
            ['name' => 'Egyption' ,'image' => 'cat3.png'],
            ['name' => 'Japanese' ,'image' => '2.png'],
            ['name' => 'Lebanese' ,'image' => 'cat1.png'],
            ['name' => 'Lebanese' ,'image' => '1.png'],
            ['name' => 'American' ,'image' => 'cat1.png'],
            ['name' => 'Arabian' ,'image' => 'cat3.png'],
            ['name' => 'Greek' ,'image' => 'cat2.png'],
            ['name' => 'Asian' ,'image' => 'cat2.png'],
        ]);
    }
}
