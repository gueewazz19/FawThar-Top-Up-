<?php

namespace Database\Seeders;

use App\Models\FAQ;
use Illuminate\Database\Seeder;

class FAQSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Apa itu GameTopUp?',
                'answer' => 'GameTopUp adalah platform digital resmi dan terpercaya untuk pembelian saldo game, voucher, dan in-game currency seperti Diamond Mobile Legends, Free Fire, UC PUBG Mobile, dan lainnya secara cepat dan otomatis 24/7.',
                'category' => 'general',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'question' => 'Berapa lama proses pengisian top up?',
                'answer' => 'Setelah pembayaran terverifikasi oleh sistem kami, pesanan akan diproses secara otomatis oleh sistem kami dalam waktu 1 hingga 3 menit.',
                'category' => 'topup',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'question' => 'Apa saja metode pembayaran yang tersedia?',
                'answer' => 'Kami mendukung berbagai metode pembayaran fleksibel: QRIS (Semua e-wallet & mobile banking), Virtual Account Bank (BCA, Mandiri, BNI, BRI), serta E-Wallet (GoPay, OVO, Dana, ShopeePay).',
                'category' => 'payment',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'question' => 'Apakah saya harus membuat akun untuk melakukan top up?',
                'answer' => 'Ya, Anda diwajibkan masuk (login) atau mendaftarkan akun. Hal ini dirancang untuk menjaga keamanan transaksi Anda, memberikan perlindungan riwayat pesanan, dan mempermudah klaim jika terjadi kendala.',
                'category' => 'account',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'question' => 'Bagaimana jika status top up gagal atau diamond belum masuk?',
                'answer' => 'Jika diamond atau item belum masuk setelah 15 menit dan status pesanan bertuliskan Gagal/Review, jangan khawatir! Saldo Anda aman dan tim Customer Support kami siap membantu Anda melakukan re-dispatch atau verifikasi.',
                'category' => 'topup',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'question' => 'Bagaimana cara menemukan Player ID game saya?',
                'answer' => 'Buka game Anda, masuk ke menu Profil atau Pengaturan di dalam game. Di sana Anda akan melihat deretan nomor User ID (dan Zone ID/Server ID dalam tanda kurung untuk game seperti Mobile Legends). Masukkan ID tersebut di form top-up kami.',
                'category' => 'topup',
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($faqs as $faq) {
            FAQ::updateOrCreate(['question' => $faq['question']], $faq);
        }
    }
}
