<?php

namespace Database\Seeders;

use App\Models\Extra;
use App\Models\MenuItem;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MenuItem::insert([
            ['name' => 'spanish salad' , 'description' => 'spanish salad with cheese', 'price' => '20' , 'menu_category_id' => 1, 'discount' =>12 , 'discount_till_date' => Carbon::today()->addDays(5), 'discount_days' => 5, 'restraunt_id' => 1],

            ['name' => 'spanish salad2' , 'description' => 'spanish salad with cheese', 'price' => '20' , 'menu_category_id' => 1, 'discount' =>12 , 'discount_till_date' => Carbon::today()->addDays(5), 'discount_days' => 5,  'restraunt_id' => 1],

            ['name' => 'Italilan salad' , 'description' => 'italilan salad with cheese', 'price' => '20' , 'menu_category_id' => 2, 'discount' =>12 , 'discount_till_date' => Carbon::today()->addDays(5), 'discount_days' => 5,  'restraunt_id' => 1],

            ['name' => 'Italilan salad2' , 'description' => 'italilan salad with cheese', 'price' => '20' , 'menu_category_id' => 2, 'discount' =>12 , 'discount_till_date' => Carbon::today()->addDays(5), 'discount_days' => 5,  'restraunt_id' => 1],

            ['name' => 'Pakistani salad' , 'description' => 'pakistan salad with cheese', 'price' => '20' , 'menu_category_id' => 3, 'discount' =>12 , 'discount_till_date' => Carbon::today()->addDays(5), 'discount_days' => 5,  'restraunt_id' => 1],

            ['name' => 'Pakistani salad2' , 'description' => 'pakistan salad with cheese', 'price' => '20' , 'menu_category_id' => 3, 'discount' =>12 , 'discount_till_date' => Carbon::today()->addDays(5), 'discount_days' => 5,  'restraunt_id' => 1],
        ]);

        Extra::insert([
            ['name' => 'extra 1' , 'price' => 20 , 'menu_item_id' => 1],
            ['name' => 'extra 2' , 'price' => 20 , 'menu_item_id' => 1],
            ['name' => 'extra 3' , 'price' => 20 , 'menu_item_id' => 2],
            ['name' => 'extra 4' , 'price' => 20 , 'menu_item_id' => 2],
            ['name' => 'extra 5' , 'price' => 20 , 'menu_item_id' => 3],
            ['name' => 'extra 6' , 'price' => 20 , 'menu_item_id' => 3],
            ['name' => 'extra 7' , 'price' => 20 , 'menu_item_id' => 4],
            ['name' => 'extra 8' , 'price' => 20 , 'menu_item_id' => 4],
        ]);
    }
}
