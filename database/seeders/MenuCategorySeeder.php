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
            ['name' => 'Seafood', 'restraunt_id' => 1,'ar_name' => 'مأكولات بحرية'],
            ['name' => 'pasta', 'restraunt_id' =>1, 'ar_name' => 'معكرونة'],
            ['name' => 'pizza', 'restraunt_id' =>1, 'ar_name' => 'بيتزا'],
            ['name' => 'burger', 'restraunt_id' =>1, 'ar_name' => 'برغر'],
            ['name' => 'sandwich', 'restraunt_id' =>1, 'ar_name' => 'ساندويتش'],
    ]);
    }
}
