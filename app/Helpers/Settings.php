<?php

namespace App\Helpers;

use App\Models\Setting;

class Settings
{
    public static function get(string $key, $default = null)
    {
        $map = [
            'company.name' => 'company_name',
            'company.address' => 'company_address',
            'company.phone' => 'company_phone',
            'company.email' => 'company_email',
            'company.logo' => 'company_logo',
            'company.ttd_dibuat' => 'ttd_dibuat',
            'company.ttd_dibuat_nip' => 'ttd_dibuat_nip',
            'company.ttd_diperiksa' => 'ttd_diperiksa',
            'company.ttd_diperiksa_nip' => 'ttd_diperiksa_nip',
            'company.ttd_menyetujui' => 'ttd_menyetujui',
            'company.ttd_menyetujui_nip' => 'ttd_menyetujui_nip',
        ];

        $dbKey = $map[$key] ?? null;
        if ($dbKey) {
            $dbValue = Setting::getValue($dbKey);
            if ($dbValue !== null) {
                return $dbValue;
            }
        }

        return config($key, $default);
    }
}
