<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\hash;

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

    return view('admin.pages.users.users', compact('users'));
}
public function show($id){
   $user = User::findOrFail($id);
    return view('admin.pages.users.edit', compact('user'));
}

public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'role' => 'required'
    ]);

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
        'password'=>Hash::make($request->password),
    ]);

    return redirect()
        ->route('admin.users.index')
        ->with('success', 'User updated successfully');
}
}
