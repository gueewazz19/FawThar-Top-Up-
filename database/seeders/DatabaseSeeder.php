<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            GameSeeder::class,
            ProductSeeder::class,
            PromotionSeeder::class,
            FAQSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
