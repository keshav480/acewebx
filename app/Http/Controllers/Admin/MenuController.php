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
        'data' => 'required|json', 
    ]);

    $settings = $request->settings ?? [];
    $formattedSettings = [
        'location' => in_array('footer', $settings) ? 'footer' : 'header',
        'auto_add_pages' => in_array('auto_add', $settings),
    ];

    $menu =  Menu::updateOrCreate(
        ['id' => $request->id],
        [
            'name' => $request->name,
            'data' => json_decode($request->data, true),
            'settings' => $formattedSettings
        ]
    );

    return redirect()->route('admin.menu')
        ->with('success', 'Menu created successfully.')->with('last_menu_id', $menu->id);;
}
    // Show a specific menu
    public function show($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.pages.menu.show', compact('menu'));
    }
        // Get menu data (AJAX)
        public function getMenu($id)
        {
            $menu = Menu::findOrFail($id);

            return response()->json([
                'id' => $menu->id,
                'name' => $menu->name,
                'data' => $menu->data,
                'settings' => $menu->settings
            ]);
        }



    // Show form to edit a menu
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $pages = Page::all();
        return view('admin.pages.menu.edit', compact('menu', 'pages'));
    }

    // Delete a menu
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('admin.menu')->with('success', 'Menu deleted successfully.');
    }
}
