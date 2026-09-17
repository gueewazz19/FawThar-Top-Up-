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
            'site_logo' => Setting::get('site_logo', ''),
            'site_tagline' => Setting::get('site_tagline', 'Top Up Game Tercepat, Termurah & Terpercaya'),
            'support_email' => Setting::get('support_email', 'support@gametopup.test'),
            'support_whatsapp' => Setting::get('support_whatsapp', '+628123456789'),
            'support_phone' => Setting::get('support_phone', '0812-3456-7890'),
            'social_instagram' => Setting::get('social_instagram', 'https://instagram.com'),
            'social_facebook' => Setting::get('social_facebook', 'https://facebook.com'),
            'social_tiktok' => Setting::get('social_tiktok', 'https://tiktok.com'),
            'meta_description' => Setting::get('meta_description', 'Platform top up game online terpercaya di Indonesia.'),
            'maintenance_mode' => (bool) Setting::get('maintenance_mode', false),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:100',
            'site_logo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'remove_logo' => 'nullable|boolean',
            'site_tagline' => 'required|string|max:200',
            'support_email' => 'required|email|max:100',
            'support_whatsapp' => 'required|string|max:30',
            'support_phone' => 'nullable|string|max:30',
            'social_instagram' => 'nullable|url|max:255',
            'social_facebook' => 'nullable|url|max:255',
            'social_tiktok' => 'nullable|url|max:255',
            'meta_description' => 'nullable|string|max:500',
            'maintenance_mode' => 'sometimes|boolean',
        ]);

        Setting::set('site_name', $validated['site_name'], 'string', 'general');

        if ($request->boolean('remove_logo')) {
            $currentLogo = Setting::get('site_logo');
            if ($currentLogo && file_exists(public_path($currentLogo))) {
                @unlink(public_path($currentLogo));
            }
            Setting::set('site_logo', '', 'string', 'general');
        } elseif ($request->hasFile('site_logo_file') && $request->file('site_logo_file')->isValid()) {
            $file = $request->file('site_logo_file');
            $filename = 'logo_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/logos'), $filename);
            Setting::set('site_logo', '/uploads/logos/' . $filename, 'string', 'general');
        } elseif ($request->filled('site_logo')) {
            Setting::set('site_logo', $request->input('site_logo'), 'string', 'general');
        }
        Setting::set('site_tagline', $validated['site_tagline'], 'string', 'general');
        Setting::set('support_email', $validated['support_email'], 'string', 'contact');
        Setting::set('support_whatsapp', $validated['support_whatsapp'], 'string', 'contact');
        Setting::set('support_phone', $validated['support_phone'] ?? $validated['support_whatsapp'], 'string', 'contact');
        Setting::set('social_instagram', $validated['social_instagram'] ?? 'https://instagram.com', 'string', 'social');
        Setting::set('social_facebook', $validated['social_facebook'] ?? 'https://facebook.com', 'string', 'social');
        Setting::set('social_tiktok', $validated['social_tiktok'] ?? 'https://tiktok.com', 'string', 'social');
        Setting::set('meta_description', $validated['meta_description'] ?? '', 'string', 'seo');
        Setting::set('maintenance_mode', $request->has('maintenance_mode') ? '1' : '0', 'boolean', 'system');

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'ADMIN_UPDATE_SETTINGS',
            'description' => 'Admin memperbarui konfigurasi sistem, branding & media sosial',
            'new_values' => $validated,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan situs, logo, kontak & media sosial berhasil disimpan.');
    }
}
