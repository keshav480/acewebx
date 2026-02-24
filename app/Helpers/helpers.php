<?php
use App\Models\Setting;
if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        return Setting::where('key', $key)->value('value') ?? $default;
    }
}
if (!function_exists('site_url')) {
function site_url($path = '') {
    $url = Setting::where('key', 'site_url')->value('value') ?? config('app.url');
    return rtrim($url, '/') . ($path ? '/' . ltrim($path, '/') : '');
}
}

if (!function_exists('site_logo')) {
function site_logo() {
    $logoPath = Setting::where('key', 'site_logo')->value('value');
    if ($logoPath) {
        return asset('storage/' . $logoPath);
    }
    return asset('images/default-logo.png');
}
}

if (!function_exists('favicon')) {
    function favicon() {
        $path = Setting::where('key', 'favicon')->value('value');
        return $path ? asset('storage/' . $path) : asset('images/favicon.ico');
    }
}