<?php

namespace Database\Seeders;

use App\Models\Promotion;
use App\Models\Voucher;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    public function run(): void
    {
        Promotion::updateOrCreate(
            ['slug' => 'super-weekend-gaming'],
            [
                'title' => 'Super Weekend Gaming Sale',
                'description' => 'Dapatkan cashback diskon hingga 15% untuk semua game top-up setiap akhir pekan.',
                'discount_type' => 'percentage',
                'discount_value' => 15,
                'start_date' => now()->subDays(2),
                'end_date' => now()->addMonths(2),
                'is_active' => true,
                'image' => 'https://images.unsplash.com/photo-1542751371-adc38448a05e?w=1200&auto=format&fit=crop&q=80',
            ]
        );

        Promotion::updateOrCreate(
            ['slug' => 'promo-pengguna-baru'],
            [
                'title' => 'Bonus Pengguna Baru',
                'description' => 'Gunakan voucher WELCOME10 untuk potongan langsung Rp 10.000 pada transaksi pertamamu.',
                'discount_type' => 'fixed',
                'discount_value' => 10000,
                'start_date' => now()->subDays(5),
                'end_date' => now()->addYear(),
                'is_active' => true,
                'image' => 'https://images.unsplash.com/photo-1511512578047-dfb367046420?w=1200&auto=format&fit=crop&q=80',
            ]
        );

        // Vouchers
        Voucher::updateOrCreate(
            ['code' => 'WELCOME10'],
            [
                'discount_type' => 'fixed',
                'discount_value' => 10000,
                'minimum_purchase' => 50000,
                'maximum_discount' => 10000,
                'usage_limit' => 1000,
                'used_count' => 0,
                'start_date' => now()->subDays(5),
                'end_date' => now()->addYear(),
                'is_active' => true,
            ]
        );

        Voucher::updateOrCreate(
            ['code' => 'GAMERPRO5'],
            [
                'discount_type' => 'percentage',
                'discount_value' => 5,
                'minimum_purchase' => 20000,
                'maximum_discount' => 25000,
                'usage_limit' => 500,
                'used_count' => 0,
                'start_date' => now()->subDays(1),
                'end_date' => now()->addMonths(6),
                'is_active' => true,
            ]
        );
    }
}
