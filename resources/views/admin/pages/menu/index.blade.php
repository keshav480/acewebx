@extends('admin.layouts.app')

@section('content')
<div class="max-w-8xl mx-auto p-6">

    <!-- Page Title -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Menus</h1>
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"id="create_menu">Create menu</button>
    </div>

    <!-- Tabs -->
    <div class="border-b border-gray-200 mb-6">
        <nav class="flex space-x-4">
            <button class="px-4 py-2 border-b-2 border-blue-600 font-medium text-blue-600">Edit Menus</button>
            <!-- <button class="px-4 py-2 text-gray-600 hover:text-gray-800">Manage Locations</button> -->
        </nav>
    </div>

    <div class="lg:flex lg:space-x-6">

        <!-- Left Panel / Menu Items -->
        <aside class="lg:w-1/3 space-y-6 flex-shrink-0">
            <div class="bg-white border border-gray-200 rounded shadow-sm p-6">
                <h2 class="text-lg font-semibold mb-4">Add menu items</h2>

                <!-- Pages -->
                <div class="mb-4">
                    <h3 class="font-medium mb-2">Pages</h3>
                    <div class="space-y-1">
                        @forelse($pages as $page)
                            <label class="flex items-center">
                                <input type="checkbox" class="mr-2 page-checkbox" value="{{ $page->id }}">
                                <input type="hidden" class="mr-2 page-slug" value="{{ $page->slug }}">
                                <span>{{ $page->title }}</span>
                            </label>
                        @empty
                            <p class="text-gray-500 text-sm">No pages to show</p>
                        @endforelse
                    </div>

                    <button class="mt-2 bg-gray-200 hover:bg-gray-300 px-3 py-1 rounded text-sm" id="addMenuBtn">
                        Add to Menu
                    </button>
                </div>

            </div>
        </aside>

        <!-- Right Panel / Menu Structure -->
        <main class="flex-1 space-y-6">
            <form method="POST" action="{{ route('admin.menu.store') }}">
                @csrf

                <div class="bg-white border border-gray-200 rounded shadow-sm p-6">
                    <h2 class="text-lg font-semibold mb-4">Menu Structure</h2>
              <select class="text-lg font-semibold mb-4 border border-gray-300" id="menuSelect">
                <option value="">Select Menu</option>

                @foreach($menus as $menu)
                    <option value="{{ $menu->id }}"
                        {{ session('last_menu_id') == $menu->id ? 'selected' : '' }}>
                        {{ $menu->name }}
                    </option>
                @endforeach
            </select>


                    <!-- Menu Name -->
                     <div class="hidden"id="menuName_outer">
                        <label class="block mb-2 text-gray-700 font-medium">Menu Name</label>
                        <input type="text" name="name" class="w-full border border-gray-300 rounded px-4 py-2 mb-4" id="menuName" value="">
                           <input type="hidden" name="id" class="w-full border border-gray-300 rounded px-4 py-2 mb-4" id="menu_id" value="">
                    </div>
                    <!-- Menu Items -->
                    <div class="space-y-2 mb-4" id="menuItemsContainer">
                        <p class="text-gray-500 text-sm">No menu items added</p>
                    </div>

                    <!-- Hidden input for JSON data -->
                    <input type="hidden" name="data" id="menuData">

                    <!-- Menu Settings -->
                    <div class="border-t border-gray-200 pt-4">
                      <h3 class="font-medium mb-2">Menu Settings</h3>

                    <label class="flex items-center mb-2">
                        <input type="checkbox" name="settings[]" value="auto_add" class="mr-2">
                        <span>Automatically add new top-level pages to this menu</span>
                    </label>

                    <label class="flex items-center mb-2">
                        <input type="checkbox" name="settings[]" value="header" class="mr-2">
                        <span>Header</span>
                    </label>

                    <label class="flex items-center">
                        <input type="checkbox" name="settings[]" value="footer" class="mr-2">
                        <span>Footer</span>
                    </label>

                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-4 flex space-x-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Save Menu</button>
                        <button type="button" class="text-red-600 hover:underline px-4 py-2" id="clearMenuBtn">Delete Menu</button>
                    </div>
                </div>
            </form>
        </main>

    </div>
</div>

@endsection
