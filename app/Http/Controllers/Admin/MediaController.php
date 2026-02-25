<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * Show media library
     */
    public function index()
    {
        
       $files = Storage::disk('public')->files('settings');
        return view('admin.media.index', compact('files'));
    }

    /**
     * Upload media
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:2048'
        ]);

        $request->file('file')->store('settings', 'public');

        return back()->with('success', 'File uploaded successfully.');
    }

    /**
     * Delete media
     */
    public function destroy($file)
    {
        Storage::disk('public')->delete('settings/' . $file);

        return back()->with('success', 'File deleted.');
    }
}
