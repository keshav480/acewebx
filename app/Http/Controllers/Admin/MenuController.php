<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Page;

class MenuController extends Controller
{
    // Display all menu items
    public function index()
    {
        $menus = Menu::all();
        $pages = Page::all();
        return view('admin.pages.menu.index', compact('menus', 'pages'));
    }

    // Show form to create a new menu
    public function create()
    {
        $pages = Page::all();
        return view('admin.pages.menu.create', compact('pages'));
    }

    // Store a new menu
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'data' => 'required|array', 
        ]);
        
        Menu::create([
            'name' => $request->name,
            'data' => $request->data, 
        ]);
        return redirect()->route('admin.menu.index')->with('success', 'Menu created successfully.');
    }

    // Show a specific menu
    public function show($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.pages.menu.show', compact('menu'));
    }

    // Show form to edit a menu
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $pages = Page::all();
        return view('admin.pages.menu.edit', compact('menu', 'pages'));
    }

    // Update a menu
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'data' => 'required|array', // Validate JSON array of menu items
        ]);

        $menu = Menu::findOrFail($id);
       
        $menu->update([
            'name' => $request->name,
            'data' => $request->data,
        ]);

        return redirect()->route('admin.menu.index')->with('success', 'Menu updated successfully.');
    }

    // Delete a menu
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('admin.menu.index')->with('success', 'Menu deleted successfully.');
    }
}
