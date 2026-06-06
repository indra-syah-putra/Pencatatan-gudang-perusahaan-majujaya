<?php

use App\Helpers\Settings;

if (!function_exists('company')) {
    function company(string $key, $default = null)
    {
        return Settings::get('company.' . $key, $default);
    }
}
