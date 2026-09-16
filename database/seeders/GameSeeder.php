<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Game;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $moba = Category::where('slug', 'moba')->first();
        $br = Category::where('slug', 'battle-royale')->first();
        $shooter = Category::where('slug', 'tactical-shooter')->first();
        $rpg = Category::where('slug', 'rpg-open-world')->first();
        $sandbox = Category::where('slug', 'sandbox-casual')->first();

        $games = [
            [
                'category_id' => $moba->id,
                'name' => 'Mobile Legends',
                'slug' => 'mobile-legends',
                'description' => 'Top up Diamond Mobile Legends termurah, instan, dan aman. Masukkan User ID dan Zone ID Anda.',
                'logo' => 'https://images.unsplash.com/photo-1542751371-adc38448a05e?w=400&auto=format&fit=crop&q=80',
                'banner' => 'https://images.unsplash.com/photo-1511512578047-dfb367046420?w=1200&auto=format&fit=crop&q=80',
                'is_active' => true,
                'requires_user_id' => true,
                'requires_server_id' => true,
                'user_id_label' => 'User ID',
                'server_id_label' => 'Zone ID',
            ],
            [
                'category_id' => $br->id,
                'name' => 'Free Fire',
                'slug' => 'free-fire',
                'description' => 'Beli Diamond Free Fire resmi harga terjangkau. Cukup masukkan Player ID Free Fire.',
                'logo' => 'https://images.unsplash.com/photo-1579373903781-fd5c0c30c4cd?w=400&auto=format&fit=crop&q=80',
                'banner' => 'https://images.unsplash.com/photo-1538481199705-c710c4e965fc?w=1200&auto=format&fit=crop&q=80',
                'is_active' => true,
                'requires_user_id' => true,
                'requires_server_id' => false,
                'user_id_label' => 'Player ID',
                'server_id_label' => null,
            ],
            [
                'category_id' => $br->id,
                'name' => 'PUBG Mobile',
                'slug' => 'pubg-mobile',
                'description' => 'Top up UC PUBG Mobile aman dan kilat langsung masuk ke akun tanpa antri.',
                'logo' => 'https://images.unsplash.com/photo-1560253023-3ec5d502959f?w=400&auto=format&fit=crop&q=80',
                'banner' => 'https://images.unsplash.com/photo-1552824722-ddab1374e622?w=1200&auto=format&fit=crop&q=80',
                'is_active' => true,
                'requires_user_id' => true,
                'requires_server_id' => false,
                'user_id_label' => 'Player ID / UID',
                'server_id_label' => null,
            ],
            [
                'category_id' => $moba->id,
                'name' => 'Honor of Kings',
                'slug' => 'honor-of-kings',
                'description' => 'Isi Token Honor of Kings cepat dan praktis untuk membuka hero dan skin favoritmu.',
                'logo' => 'https://images.unsplash.com/photo-1612287233207-646e33e498c5?w=400&auto=format&fit=crop&q=80',
                'banner' => 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?w=1200&auto=format&fit=crop&q=80',
                'is_active' => true,
                'requires_user_id' => true,
                'requires_server_id' => false,
                'user_id_label' => 'Player ID',
                'server_id_label' => null,
            ],
            [
                'category_id' => $rpg->id,
                'name' => 'Genshin Impact',
                'slug' => 'genshin-impact',
                'description' => 'Genesis Crystals dan Blessing of the Welkin Moon Genshin Impact termurah.',
                'logo' => 'https://images.unsplash.com/photo-1578632767115-351597cf2477?w=400&auto=format&fit=crop&q=80',
                'banner' => 'https://images.unsplash.com/photo-1519638399535-1b036603ac77?w=1200&auto=format&fit=crop&q=80',
                'is_active' => true,
                'requires_user_id' => true,
                'requires_server_id' => true,
                'user_id_label' => 'UID',
                'server_id_label' => 'Server (Asia/America/Europe/TW-HK-MO)',
            ],
            [
                'category_id' => $shooter->id,
                'name' => 'Valorant',
                'slug' => 'valorant',
                'description' => 'Beli Valorant Points (VP) resmi untuk bundle skin dan battle pass terbaru.',
                'logo' => 'https://images.unsplash.com/photo-1563089145-599997674d42?w=400&auto=format&fit=crop&q=80',
                'banner' => 'https://images.unsplash.com/photo-1542751110-97427bbecf20?w=1200&auto=format&fit=crop&q=80',
                'is_active' => true,
                'requires_user_id' => true,
                'requires_server_id' => false,
                'user_id_label' => 'Riot ID (Contoh: Player#TAG)',
                'server_id_label' => null,
            ],
            [
                'category_id' => $sandbox->id,
                'name' => 'Roblox',
                'slug' => 'roblox',
                'description' => 'Top up Robux instan dan aman untuk custom avatar dan game passes.',
                'logo' => 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?w=400&auto=format&fit=crop&q=80',
                'banner' => 'https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?w=1200&auto=format&fit=crop&q=80',
                'is_active' => true,
                'requires_user_id' => true,
                'requires_server_id' => false,
                'user_id_label' => 'Roblox Username',
                'server_id_label' => null,
            ],
        ];

        foreach ($games as $game) {
            Game::updateOrCreate(['slug' => $game['slug']], $game);
        }
    }
}
