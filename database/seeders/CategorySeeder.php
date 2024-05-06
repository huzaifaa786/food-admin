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
            ['name' => 'Indian' ,'image' => 'images/categories/cat1.png', 'ar_name' => 'هندي'],
            ['name' => 'Chinese' ,'image' =>'images/categories/cat2.png', 'ar_name' => 'صيني'],
            ['name' => 'Brazilian' ,'image' =>'images/categories/cat3.png', 'ar_name' => 'برازيلي'],
            ['name' => 'Italian' ,'image' =>'images/categories/cat1.png', 'ar_name' => 'برازيلي'],
            ['name' => 'Egyption' ,'image' =>'images/categories/cat3.png', 'ar_name' => 'مصري'],
            ['name' => 'Japanese' ,'image' =>'images/categories/2.png', 'ar_name' => 'ياباني'],
            ['name' => 'Lebanese' ,'image' =>'images/categories/cat1.png', 'ar_name' => 'لبناني'],
            ['name' => 'American' ,'image' =>'images/categories/cat1.png', 'ar_name' => 'أمريكي'],
            ['name' => 'Arabian' ,'image' =>'images/categories/cat3.png', 'ar_name' => 'عربي'],
            ['name' => 'Greek' ,'image' =>'images/categories/cat2.png', 'ar_name' => 'يوناني'],
            ['name' => 'Asian' ,'image' =>'images/categories/cat2.png', 'ar_name' => 'آسيوي'],
        ]);
    }
}
