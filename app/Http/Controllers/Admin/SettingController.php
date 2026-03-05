<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display settings form.
     */
    public function index()
    {
        $settings = Setting::getPaymentSettings();
        $siteSettings = Setting::getSiteSettings();
        return view('admin.settings.index', compact('settings', 'siteSettings'));
    }

    /**
     * Update settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'bank1_nama' => 'required|string|max:100',
            'bank1_norek' => 'required|string|max:50',
            'bank1_atas_nama' => 'required|string|max:100',
            'bank2_nama' => 'nullable|string|max:100',
            'bank2_norek' => 'nullable|string|max:50',
            'bank2_atas_nama' => 'nullable|string|max:100',
            'qris_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'qris_atas_nama' => 'required|string|max:100',
            'site_name' => 'nullable|string|max:100',
            'site_logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:500',
            'hero_badge' => 'nullable|string|max:100',
            'hero_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'wa_konfirmasi' => 'nullable|string|max:20',
        ]);

        // Save bank settings
        Setting::set('bank1_nama', $request->bank1_nama);
        Setting::set('bank1_norek', $request->bank1_norek);
        Setting::set('bank1_atas_nama', $request->bank1_atas_nama);
        Setting::set('bank2_nama', $request->bank2_nama);
        Setting::set('bank2_norek', $request->bank2_norek);
        Setting::set('bank2_atas_nama', $request->bank2_atas_nama);
        Setting::set('qris_atas_nama', $request->qris_atas_nama);

        // Handle QRIS image upload
        if ($request->hasFile('qris_image')) {
            $path = $request->file('qris_image')->store('qris', 'public');
            Setting::set('qris_image', 'storage/' . $path);
        }

        // Save site settings
        if ($request->filled('site_name')) {
            Setting::set('site_name', $request->site_name);
        }

        if ($request->filled('hero_title')) {
            Setting::set('hero_title', $request->hero_title);
        }

        if ($request->filled('hero_subtitle')) {
            Setting::set('hero_subtitle', $request->hero_subtitle);
        }

        if ($request->filled('hero_badge')) {
            Setting::set('hero_badge', $request->hero_badge);
        }

        if ($request->filled('wa_konfirmasi')) {
            Setting::set('wa_konfirmasi', $request->wa_konfirmasi);
        }

        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            $path = $request->file('site_logo')->store('site', 'public');
            Setting::set('site_logo', 'storage/' . $path);
        }

        // Handle hero image upload
        if ($request->hasFile('hero_image')) {
            $path = $request->file('hero_image')->store('hero', 'public');
            Setting::set('hero_image', 'storage/' . $path);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil disimpan.');
    }
}
