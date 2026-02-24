<header id="site-header"class="sticky top-0 z-50 bg-gradient-to-r from-slate-900 to-slate-950 border-b border-white/10 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between h-18 py-4">
            <a href="{{ site_url() }}" class="flex items-center">
                <img src="{{site_logo()}}"
                     alt="Acewebx"
                     class="h-9">
            </a>
            <!-- Navigation -->
            <nav class="hidden md:flex items-center gap-8">
                    @foreach($headerMenus as $menu)
                        @php
                            $items = is_array($menu->data)
                                ? $menu->data
                                : json_decode($menu->data, true);
                        @endphp
                        @foreach($items as $item)
                                <a href="{{ $item['slug'] }}"class="text-white text-sm font-medium hover:text-white/80">
                                    {{ $item['title'] }}
                                </a>
                            </li>
                        @endforeach
                    @endforeach
            </nav>
            <!-- CTA -->
             @guest
            <a href="{{route('login')}}"
               class="bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-5 py-2.5 rounded-md transition">
                Join Us
            </a>
            @endguest
            @auth
            <div class="relative">
                    <button id="user-menu-button" class="flex items-center gap-2 text-white focus:outline-none">
                        <img src="{{ asset('admin/images/user-avatar.png') }}" 
                            alt="User Avatar" class="h-8 w-8 rounded-full">
                        <span class="text-sm font-medium"> {{ auth()->user()->name ?? 'Guest' }}</span>
                        <i class="fa fa-chevron-down text-sm"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="user-menu" class="hidden absolute right-0 mt-2 w-40 bg-white text-gray-900 rounded shadow-lg py-2">
                        <a href="{{ route('profile') }}" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                        <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"class="block px-4 py-2 hover:bg-gray-100">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf <!-- Blade directive for CSRF token -->
                        </form>
                    </div>
                </div>
                @endauth
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
