<?php
use App\Models\Setting;
use App\Models\Page;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;


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
if (!function_exists('has_role_permission')) {
    function has_role_permission(string $role, string $permission): bool
    {
        $roleId = \Spatie\Permission\Models\Role::where('name', $role)->pluck('id')->first();
        if (!$roleId) return false;

        $permissionId = \Spatie\Permission\Models\Permission::where('name', $permission)->pluck('id')->first();
        if (!$permissionId) return false;

        return \Illuminate\Support\Facades\DB::table('role_has_permissions')
            ->where('role_id', $roleId)
            ->where('permission_id', $permissionId)
            ->exists();
    }
}



