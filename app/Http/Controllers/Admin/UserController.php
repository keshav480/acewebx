<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\hash;
use Spatie\Permission\Models\Role;


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
  $roles = Role::pluck('name', 'name');
  $user = User::with('roles')->findOrFail($id);

    return view('admin.pages.users.edit', compact('user', 'roles'));
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
public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()
        ->route('admin.users.index')
        ->with('success', 'User deleted successfully');
}
}
