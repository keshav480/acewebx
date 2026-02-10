<aside class="w-64 bg-gray-800 text-gray-100 flex-shrink-0 h-screen flex flex-col">
        <div class="p-6 text-xl font-bold border-b border-gray-700 flex items-center gap-2">
            <img src="{{ asset('admin/images/user-avatar.png') }}" alt="User Avatar" class="h-8 w-8 rounded-full">
            <span class="text-sm font-medium">Admin</span>
        </div>

        <nav class="mt-6 flex-1">
            <a href="{{ route('admin.dashboard') }}" 
               class="block px-6 py-2 mt-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
               Dashboard
            </a>
            <a href="{{ route('admin.users.index') }}" 
               class="block px-6 py-2 mt-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.users.*') ? 'bg-gray-700' : '' }}">
               Users
            </a>
            <a href="{{ route('admin.settings') }}" 
               class="block px-6 py-2 mt-2 rounded hover:bg-gray-700 {{ request()->routeIs('admin.settings') ? 'bg-gray-700' : '' }}">
               Settings
            </a>
        </nav>
    </aside>