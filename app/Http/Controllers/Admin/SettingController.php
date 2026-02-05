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
        return view('admin.settings.index', compact('settings'));
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

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan pembayaran berhasil disimpan.');
    }
}
