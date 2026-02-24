<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.pages.settings', compact('settings'));   
    }

   public function store(Request $request)
{
    $fileFields = ['site_logo', 'favicon'];

    foreach ($fileFields as $field) {

        // 1️⃣ Remove old file if user clicked the cross
        if ($request->input('remove_'.$field) == '1') {
            $old = Setting::where('key', $field)->first();
            if ($old && $old->value && Storage::disk('public')->exists($old->value)) {
                Storage::disk('public')->delete($old->value);
            }

            Setting::updateOrCreate(
                ['key' => $field],
                ['value' => null]  
            );
        }

        // 2️⃣ Save new uploaded file if any
        if ($request->hasFile($field)) {
            $file = $request->file($field);
            $path = $file->store('settings', 'public');

            Setting::updateOrCreate(
                ['key' => $field],
                ['value' => $path]
            );
        }
    }

    // 3️⃣ Save all other fields
    foreach ($request->except(array_merge($fileFields, ['_token'])) as $key => $value) {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    return back()->with('success', 'Settings saved successfully');
}
}
