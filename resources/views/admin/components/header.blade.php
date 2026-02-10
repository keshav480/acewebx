<header id="admin-header"
        class="sticky top-0 z-50 bg-gradient-to-r from-slate-900 to-slate-950 border-b border-white/10 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between h-16 py-3">

            <!-- Logo -->
            <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                <img src="{{ asset('public/images/Logo.svg') }}" alt="Acewebx" class="h-9">
                <span class="ml-2 text-white font-bold text-lg"></span>
            </a>

            <!-- Left: Sidebar Toggle (for mobile) -->
            <button id="sidebar-toggle" class="md:hidden text-white focus:outline-none">
                <i class="fa fa-bars text-xl"></i>
            </button>

            <!-- Navigation / User Menu -->
            <div class="hidden md:flex items-center gap-6">

                <!-- Quick Links (optional) -->
              @foreach(config('menu.header') as $item)
                    <a href="{{ route($item['route']) }}"
                    class="text-white block px-6 py-2 mt-2 rounded hover:bg-gray-700 ">
                    @if(isset($item['icon']))
                        <i class="{{ $item['icon'] }} mr-2"></i>
                    @endif
                    {{ $item['title'] }}
                    </a>
                @endforeach

                <!-- User Dropdown -->
                <div class="relative">
                    <button id="user-menu-button" class="flex items-center gap-2 text-white focus:outline-none">
                        <img src="{{ asset('admin/images/user-avatar.png') }}" 
                             alt="User Avatar" class="h-8 w-8 rounded-full">
                        <span class="text-sm font-medium">Admin</span>
                        <i class="fa fa-chevron-down text-sm"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="user-menu" class="hidden absolute right-0 mt-2 w-40 bg-white text-gray-900 rounded shadow-lg py-2">
                        <a href="{{ route('admin.profile') }}" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                        <a href="" class="block px-4 py-2 hover:bg-gray-100">Logout</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</header>

<!-- Optional JS for dropdown toggle -->
<script>
    const userBtn = document.getElementById('user-menu-button');
    const userMenu = document.getElementById('user-menu');
    userBtn?.addEventListener('click', () => {
        userMenu.classList.toggle('hidden');
    });

    // Optional: sidebar toggle for mobile
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.querySelector('aside');
    sidebarToggle?.addEventListener('click', () => {
        sidebar?.classList.toggle('hidden');
    });
</script>
