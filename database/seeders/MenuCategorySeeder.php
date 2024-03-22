<?php

namespace Database\Seeders;

use App\Models\MenuCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MenuCategory::insert([
            ['name' => 'Seafood', 'restraunt_id' => 1],
            ['name' => 'pasta', 'restraunt_id' => 1],
            ['name' => 'pizza', 'restraunt_id' => 1],
            ['name' => 'burger', 'restraunt_id' => 1],
            ['name' => 'sandwich', 'restraunt_id' => 1],
    ]);
    }
}
