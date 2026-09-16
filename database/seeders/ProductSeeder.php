<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Mobile Legends Packages
        $ml = Game::where('slug', 'mobile-legends')->first();
        if ($ml) {
            $mlPackages = [
                ['name' => '86 Diamonds', 'currency_amount' => '86 Diamonds', 'price' => 21000, 'cost' => 19500, 'is_popular' => false, 'sort_order' => 1],
                ['name' => '172 Diamonds', 'currency_amount' => '172 Diamonds', 'price' => 42000, 'cost' => 39000, 'is_popular' => true, 'sort_order' => 2],
                ['name' => '257 Diamonds', 'currency_amount' => '257 Diamonds', 'price' => 63000, 'cost' => 58500, 'is_popular' => false, 'sort_order' => 3],
                ['name' => '344 Diamonds', 'currency_amount' => '344 Diamonds', 'price' => 84000, 'cost' => 78000, 'is_popular' => false, 'sort_order' => 4],
                ['name' => '429 Diamonds', 'currency_amount' => '429 Diamonds', 'price' => 105000, 'cost' => 97500, 'is_popular' => false, 'sort_order' => 5],
                ['name' => '514 Diamonds', 'currency_amount' => '514 Diamonds', 'price' => 125000, 'cost' => 116000, 'is_popular' => true, 'sort_order' => 6],
                ['name' => '706 Diamonds', 'currency_amount' => '706 Diamonds', 'price' => 168000, 'cost' => 156000, 'is_popular' => false, 'sort_order' => 7],
                ['name' => 'Weekly Diamond Pass', 'currency_amount' => 'Weekly Pass', 'price' => 28000, 'cost' => 26000, 'is_popular' => true, 'sort_order' => 0],
            ];
            foreach ($mlPackages as $pkg) {
                Product::updateOrCreate(['game_id' => $ml->id, 'name' => $pkg['name']], $pkg);
            }
        }

        // Free Fire Packages
        $ff = Game::where('slug', 'free-fire')->first();
        if ($ff) {
            $ffPackages = [
                ['name' => '70 Diamonds', 'currency_amount' => '70 Diamonds', 'price' => 10000, 'cost' => 9200, 'is_popular' => false, 'sort_order' => 1],
                ['name' => '140 Diamonds', 'currency_amount' => '140 Diamonds', 'price' => 20000, 'cost' => 18400, 'is_popular' => true, 'sort_order' => 2],
                ['name' => '355 Diamonds', 'currency_amount' => '355 Diamonds', 'price' => 50000, 'cost' => 46000, 'is_popular' => true, 'sort_order' => 3],
                ['name' => '720 Diamonds', 'currency_amount' => '720 Diamonds', 'price' => 100000, 'cost' => 92000, 'is_popular' => false, 'sort_order' => 4],
                ['name' => '1450 Diamonds', 'currency_amount' => '1450 Diamonds', 'price' => 200000, 'cost' => 184000, 'is_popular' => false, 'sort_order' => 5],
            ];
            foreach ($ffPackages as $pkg) {
                Product::updateOrCreate(['game_id' => $ff->id, 'name' => $pkg['name']], $pkg);
            }
        }

        // PUBG Mobile Packages
        $pubg = Game::where('slug', 'pubg-mobile')->first();
        if ($pubg) {
            $pubgPackages = [
                ['name' => '60 UC', 'currency_amount' => '60 UC', 'price' => 15000, 'cost' => 13800, 'is_popular' => false, 'sort_order' => 1],
                ['name' => '325 UC', 'currency_amount' => '325 UC', 'price' => 75000, 'cost' => 69000, 'is_popular' => true, 'sort_order' => 2],
                ['name' => '660 UC', 'currency_amount' => '660 UC', 'price' => 150000, 'cost' => 138000, 'is_popular' => true, 'sort_order' => 3],
                ['name' => '1800 UC', 'currency_amount' => '1800 UC', 'price' => 380000, 'cost' => 350000, 'is_popular' => false, 'sort_order' => 4],
            ];
            foreach ($pubgPackages as $pkg) {
                Product::updateOrCreate(['game_id' => $pubg->id, 'name' => $pkg['name']], $pkg);
            }
        }

        // Valorant Packages
        $val = Game::where('slug', 'valorant')->first();
        if ($val) {
            $valPackages = [
                ['name' => '475 VP', 'currency_amount' => '475 VP', 'price' => 55000, 'cost' => 51000, 'is_popular' => false, 'sort_order' => 1],
                ['name' => '1000 VP', 'currency_amount' => '1000 VP', 'price' => 110000, 'cost' => 102000, 'is_popular' => true, 'sort_order' => 2],
                ['name' => '2050 VP', 'currency_amount' => '2050 VP', 'price' => 220000, 'cost' => 204000, 'is_popular' => false, 'sort_order' => 3],
                ['name' => '3650 VP', 'currency_amount' => '3650 VP', 'price' => 380000, 'cost' => 352000, 'is_popular' => false, 'sort_order' => 4],
            ];
            foreach ($valPackages as $pkg) {
                Product::updateOrCreate(['game_id' => $val->id, 'name' => $pkg['name']], $pkg);
            }
        }
    }
}
