<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@mail.com',
            'password' => '123456',
            'phone' => '897563355',
        ]);
        $this->call(CategorySeeder::class);
        $this->call(RestrauntSeeder::class);
        $this->call(MenuCategorySeeder::class);
        $this->call(MenuItemSeeder::class);
        $this->call(AdminSeeder::class);
    }
}
