<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'company_logo' => Setting::getValue('company_logo'),
            'company_name' => Setting::getValue('company_name', config('company.name')),
            'company_address' => Setting::getValue('company_address', config('company.address')),
            'company_phone' => Setting::getValue('company_phone', config('company.phone')),
            'company_email' => Setting::getValue('company_email', config('company.email')),
            'ttd_dibuat' => Setting::getValue('ttd_dibuat', config('company.ttd_dibuat')),
            'ttd_dibuat_nip' => Setting::getValue('ttd_dibuat_nip', config('company.ttd_dibuat_nip')),
            'ttd_diperiksa' => Setting::getValue('ttd_diperiksa', config('company.ttd_diperiksa')),
            'ttd_diperiksa_nip' => Setting::getValue('ttd_diperiksa_nip', config('company.ttd_diperiksa_nip')),
            'ttd_menyetujui' => Setting::getValue('ttd_menyetujui', config('company.ttd_menyetujui')),
            'ttd_menyetujui_nip' => Setting::getValue('ttd_menyetujui_nip', config('company.ttd_menyetujui_nip')),
        ];

        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string|max:500',
            'company_phone' => 'required|string|max:50',
            'company_email' => 'required|email|max:255',
            'ttd_dibuat' => 'required|string|max:255',
            'ttd_dibuat_nip' => 'required|string|max:50',
            'ttd_diperiksa' => 'required|string|max:255',
            'ttd_diperiksa_nip' => 'required|string|max:50',
            'ttd_menyetujui' => 'required|string|max:255',
            'ttd_menyetujui_nip' => 'required|string|max:50',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        foreach ($validated as $key => $value) {
            if ($key !== 'logo') {
                Setting::setValue($key, $value);
            }
        }

        if ($request->hasFile('logo')) {
            $oldLogo = Setting::getValue('company_logo');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }
            $path = $request->file('logo')->store('logos', 'public');
            Setting::setValue('company_logo', $path);
        } elseif ($request->boolean('remove_logo')) {
            $oldLogo = Setting::getValue('company_logo');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }
            Setting::setValue('company_logo', '');
        }

        return redirect()->route('settings.index')->with('success', 'Pengaturan berhasil disimpan.');
    }
}
