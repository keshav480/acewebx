<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index(){
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.pages.settings', compact('settings'));   
    }
    public function store(Request $request)
    {

        foreach ($request->except('_token') as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
        return back()->with('success', 'Settings saved successfully');
    }
    
}
