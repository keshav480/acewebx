<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class ChatController extends Controller
{
    public function index()
    {
        $userdata = User::where('id', '!=', auth()->id())->pluck('name', 'id');
        return view('admin.pages.chat.index', compact('userdata'));
    }

    public function show($id)
    {
        $userdata = User::where('id', '!=', auth()->id())->pluck('name', 'id');
        $user = User::select('id', 'name')->findOrFail($id);
        return view('admin.pages.chat.index', compact('userdata', 'user'));
    }
}
