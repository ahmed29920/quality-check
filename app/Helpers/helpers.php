<?php

use App\Models\Setting;

if (! function_exists('setting')) {
    function setting($key, $default = null)
    {
        static $settings = null;

        if ($settings === null) {
            $settings = cache()->rememberForever('settings.all', function () {
                return Setting::pluck('value', 'key')->toArray();
            });
        }
        
        return $settings[$key] ?? $default;
    }
}
