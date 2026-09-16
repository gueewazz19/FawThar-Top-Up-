<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'MOBA', 'slug' => 'moba', 'description' => 'Multiplayer Online Battle Arena Games'],
            ['name' => 'Battle Royale', 'slug' => 'battle-royale', 'description' => 'Survival Battle Royale Games'],
            ['name' => 'Tactical Shooter', 'slug' => 'tactical-shooter', 'description' => 'FPS and Tactical Shooter Games'],
            ['name' => 'RPG & Open World', 'slug' => 'rpg-open-world', 'description' => 'Role-playing and Open World Adventure Games'],
            ['name' => 'Sandbox & Casual', 'slug' => 'sandbox-casual', 'description' => 'Creative Sandbox and Casual Games'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
