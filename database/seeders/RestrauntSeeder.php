<?php

namespace Database\Seeders;

use App\Models\Restraunt;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestrauntSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Restraunt::create([
            'name' => 'Charsi Restaurant',
            'email' => 'res@mail.com',
            'phone' => '0306585968',
            'description' => 'description comes here',
            'lat' => '32.1060864',
            'lng' => '72.6925312',
            'password' => '123456',
            'radius' => '50',
            'category_id' => 1,
        ]);
    }
}
