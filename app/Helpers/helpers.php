<?php
use App\Models\Setting;
use App\Models\Page;

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        return Setting::where('key', $key)->value('value') ?? $default;
    }
}
if (!function_exists('site_title')) {
    function site_title(): string
    {
        return Setting::where('key', 'site_title')->value('value') ?? config('app.name');
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
if (!function_exists('seo_meta')) {
    function seo_meta($field = null)
    {
        $slug = request()->segment(1);
        $page = cache()->remember("seo_page_{$slug}", 300, function () use ($slug) {
            return \App\Models\Page::where('slug', $slug)->first();
        });
        return $field ? ($page->$field ?? null) : $page;
    }
}
