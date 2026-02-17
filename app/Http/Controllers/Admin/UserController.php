<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
public function index()
{
    $users = \App\Models\User::query();

    // Search filter
    if (request('search')) {
        $users->where(function ($query) {
            $query->where('name', 'like', '%' . request('search') . '%')
                  ->orWhere('email', 'like', '%' . request('search') . '%');
        });
    }

    $users = $users->latest()->paginate(10)->withQueryString();

    return view('admin.pages.users', compact('users'));
}
}
