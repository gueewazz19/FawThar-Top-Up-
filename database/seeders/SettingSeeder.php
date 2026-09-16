<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'GameTopUp', 'type' => 'string', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Top Up Game Tercepat, Termurah & Terpercaya', 'type' => 'string', 'group' => 'general'],
            ['key' => 'support_email', 'value' => 'support@gametopup.test', 'type' => 'string', 'group' => 'contact'],
            ['key' => 'support_whatsapp', 'value' => '+628123456789', 'type' => 'string', 'group' => 'contact'],
            ['key' => 'meta_description', 'value' => 'Platform top up game online terpercaya di Indonesia. Beli Diamond MLBB, Free Fire, UC PUBG Mobile, Valorant Points instan 24 jam.', 'type' => 'string', 'group' => 'seo'],
            ['key' => 'maintenance_mode', 'value' => '0', 'type' => 'boolean', 'group' => 'system'],
        ];

        foreach ($settings as $s) {
            Setting::updateOrCreate(['key' => $s['key']], $s);
        }
    }
}
