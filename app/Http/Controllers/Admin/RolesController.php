<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    // list roles
    public function index()
    {
        $roles = Role::latest()->paginate(10);
        return view('admin.pages.roles.index', compact('roles'));
    }

    // show create form
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.pages.roles.create', compact('permissions'));
    }

    // store role
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|unique:roles,name',
        'permissions' => 'nullable|array'
    ]);

    // Create role
    $role = Role::create([
        'name' => $request->name
    ]);

    // Assign permissions
    if ($request->permissions) {
        $role->syncPermissions($request->permissions);
    }

    return redirect()
        ->route('admin.roles.index')
        ->with('success', 'Role created successfully');
}

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        return view('admin.pages.roles.edit', compact(
            'role',
            'permissions',
            'rolePermissions'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'nullable|array',
        ]);
        $role = Role::findOrFail($id);
        $role->update([
            'name' => $request->name
        ]);
        $permissions = $request->input('permissions', []);
        $role->syncPermissions($permissions);
        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully');
    }

   public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->syncPermissions([]);
        $role->delete();
        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully');
    }
    
}
