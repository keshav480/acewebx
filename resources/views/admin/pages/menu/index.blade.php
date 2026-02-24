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

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){

    let menuItems = [];

    // =============================
    // SHOW MENU NAME FIELD
    // =============================
    $('#create_menu').click(function(){
        $('#menuName_outer').removeClass('hidden');
        $('#menuName').val('');
        $('#menuSelect').val('');
        $('#menuItemsContainer').html('');
        $('#menu_id').val('');
    });

    // =============================
    // LOAD MENU WHEN DROPDOWN CHANGES
    // =============================
    $('#menuSelect').change(function(){

        let menuId = $(this).val();
        let selectedText = $(this).find("option:selected").text();

        $('#menuName_outer').removeClass('hidden');
        $('#menuName').val($.trim(selectedText));
        $('#menu_id').val($.trim(menuId));

        if(!menuId){
            menuItems = [];
            $('#menuItemsContainer').html('<p class="text-gray-500 text-sm">No menu items added</p>');
            return;
        }

        $.get('/ace-admin/menu/' + menuId, function(res){
            menuItems = res.data || [];
            let settings = res.settings || [];
            $('#menuItemsContainer').empty();
            if(menuItems.length === 0){
                $('#menuItemsContainer').html('<p class="text-gray-500 text-sm">No menu items added</p>');
            } else {
                renderMenuItems();
            }
            $('#menuData').val(JSON.stringify(menuItems));
            $('input[name="settings[]"]').prop('checked', false);
            if(settings){
              let settings = res.settings || {};

            // uncheck everything first
            $('input[name="settings[]"]').prop('checked', false);

            // set auto add pages
            if(settings.auto_add_pages === true){
                $('input[name="settings[]"][value="auto_add"]').prop('checked', true);
            }

            // set location
            if(settings.location){
                $('input[name="settings[]"][value="'+settings.location+'"]').prop('checked', true);
            }

            }
        });

    });

    // =============================
    // AUTO LOAD SELECTED MENU (IMPORTANT → AFTER EVENT BIND)
    // =============================
    if($('#menuSelect').val()){
        $('#menuSelect').trigger('change');
    }

    // =============================
    // ADD MENU ITEM
    // =============================
    $('#addMenuBtn').click(function(){

        $('.page-checkbox:checked').each(function(){

            let id = $(this).val();
            let title = $(this).siblings('span').text();

            menuItems.push({
                id: id,
                title: title
            });

            $(this).prop('checked', false);
        });

        renderMenuItems();
        $('#menuData').val(JSON.stringify(menuItems));
    });

    // =============================
    // REMOVE ITEM
    // =============================
    $('#menuItemsContainer').on('click', '.removeItemBtn', function(){

        let index = $(this).closest('div').index();
        menuItems.splice(index, 1);

        renderMenuItems();
        $('#menuData').val(JSON.stringify(menuItems));
    });

    // =============================
    // DELETE MENU (FIXED LOCATION)
    // =============================
    $('#clearMenuBtn').click(function(){

        let menuId = $('#menuSelect').val();

        if(!menuId){
            alert('Please select a menu first');
            return;
        }

        if(!confirm('Are you sure you want to delete this menu?')){
            return;
        }

        $.ajax({
            url: '/ace-admin/menu/' + menuId,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(){

                alert('Menu deleted successfully');

                menuItems = [];
                $('#menuItemsContainer').html('<p class="text-gray-500 text-sm">No menu items added</p>');
                $('#menuData').val('');
                $('#menuName').val('');
                $('#menuSelect option:selected').remove();
            }
        });
    });

    // =============================
    // RENDER MENU ITEMS (NEW)
    // =============================
    function renderMenuItems(){

        $('#menuItemsContainer').empty();

        if(menuItems.length === 0){
            $('#menuItemsContainer').html('<p class="text-gray-500 text-sm">No menu items added</p>');
            return;
        }

        menuItems.forEach(function(item){
            $('#menuItemsContainer').append(`
                <div class="border border-gray-300 rounded p-2 flex justify-between items-center">
                    <span>${item.title}</span>
                    <button type="button" class="text-red-600 text-sm removeItemBtn">Remove</button>
                </div>
            `);
        });
    }

});

</script>
@endsection
