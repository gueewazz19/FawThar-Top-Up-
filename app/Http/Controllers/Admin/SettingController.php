<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'site_name' => Setting::get('site_name', 'GameTopUp'),
            'site_tagline' => Setting::get('site_tagline', 'Top Up Game Tercepat, Termurah & Terpercaya'),
            'support_email' => Setting::get('support_email', 'support@gametopup.test'),
            'support_whatsapp' => Setting::get('support_whatsapp', '+628123456789'),
            'meta_description' => Setting::get('meta_description', 'Platform top up game online terpercaya di Indonesia.'),
            'maintenance_mode' => (bool) Setting::get('maintenance_mode', false),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:100',
            'site_tagline' => 'required|string|max:200',
            'support_email' => 'required|email|max:100',
            'support_whatsapp' => 'required|string|max:30',
            'meta_description' => 'nullable|string|max:500',
            'maintenance_mode' => 'sometimes|boolean',
        ]);

        Setting::set('site_name', $validated['site_name'], 'string', 'general');
        Setting::set('site_tagline', $validated['site_tagline'], 'string', 'general');
        Setting::set('support_email', $validated['support_email'], 'string', 'contact');
        Setting::set('support_whatsapp', $validated['support_whatsapp'], 'string', 'contact');
        Setting::set('meta_description', $validated['meta_description'] ?? '', 'string', 'seo');
        Setting::set('maintenance_mode', $request->has('maintenance_mode') ? '1' : '0', 'boolean', 'system');

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'ADMIN_UPDATE_SETTINGS',
            'description' => 'Admin memperbarui konfigurasi sistem',
            'new_values' => $validated,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan situs berhasil disimpan.');
    }
}
