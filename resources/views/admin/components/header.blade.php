<header id="admin-header"
        class="sticky top-0 z-50 bg-gradient-to-r from-slate-900 to-slate-950 border-b border-white/10 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between h-12 py-3">

            <!-- Logo -->
            <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                <img src="{{site_logo()}}" alt="Acewebx" class="h-9">
                <span class="ml-2 text-white font-bold text-lg"></span>
            </a>

            <!-- Left: Sidebar Toggle (for mobile) -->
            <button id="sidebar-toggle" class="md:hidden text-white focus:outline-none">
                <i class="fa fa-bars text-xl"></i>
            </button>

            <!-- Navigation / User Menu -->
            <div class="hidden md:flex items-center gap-6">
              @foreach(config('menu.header') as $item)
                    <a href="{{ route($item['route']) }}"
                    class="text-white block px-6 py-2 mt-2 rounded hover:bg-gray-700 ">
                    @if(isset($item['icon']))
                        <i class="{{ $item['icon'] }} mr-2"></i>
                    @endif
                    {{ $item['title'] }}
                    </a>
                @endforeach
               <div x-data="{ open: false, notifying: {{ $unreadCount > 0 ? 'true' : 'false' }} }" class="relative inline-block">
                <button @click="open = !open" class="text-white block px-2 py-2 mt-1 rounded hover:bg-gray-700">
                    <!-- Dot only shows if there are unread notifications -->
                    <span x-show="notifying" class="absolute top-0.5 right-0 h-2 w-2 rounded-full bg-orange-400 hidden showdots" id="showdots">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-orange-400 opacity-75"></span>
                    </span>
                    <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.75 2.29248C10.75 1.87827 10.4143 1.54248 10 1.54248C9.58583 1.54248 9.25004 1.87827 9.25004 2.29248V2.83613C6.08266 3.20733 3.62504 5.9004 3.62504 9.16748V14.4591H3.33337C2.91916 14.4591 2.58337 14.7949 2.58337 15.2091C2.58337 15.6234 2.91916 15.9591 3.33337 15.9591H4.37504H15.625H16.6667C17.0809 15.9591 17.4167 15.6234 17.4167 15.2091C17.4167 14.7949 17.0809 14.4591 16.6667 14.4591H16.375V9.16748C16.375 5.9004 13.9174 3.20733 10.75 2.83613V2.29248ZM14.875 14.4591V9.16748C14.875 6.47509 12.6924 4.29248 10 4.29248C7.30765 4.29248 5.12504 6.47509 5.12504 9.16748V14.4591H14.875ZM8.00004 17.7085C8.00004 18.1228 8.33583 18.4585 8.75004 18.4585H11.25C11.6643 18.4585 12 18.1228 12 17.7085C12 17.2943 11.6643 16.9585 11.25 16.9585H8.75004C8.33583 16.9585 8.00004 17.2943 8.00004 17.7085Z" fill="currentColor"></path>
                    </svg>
                </button>

    <!-- Dropdown -->
                    <div x-show="open" 
                    x-transition 
                    @click.outside="open = false" 
                    x-cloak 
                    class="absolute right-0 mt-2 w-72 bg-white text-black rounded shadow-lg max-h-96 overflow-y-auto z-50">
                        <div class="px-4 py-2 font-bold border-b bg-gray-50 flex justify-between items-center">
                            <span>Notifications</span>
                            @if($unreadCount > 0)
                                <span class="text-xs bg-orange-400 text-white px-2 py-0.5 rounded-full">{{ $unreadCount }} New</span>
                            @endif
                        </div>

                        <div id="notification-list" class="divide-y">
                            @forelse($headerNotifications as $notification)
                            @php 
                             $data = json_decode($notification->data, true);
                            @endphp 
                                <div class="px-4 py-3 hover:bg-gray-50 transition {{ is_null($notification->read_at) ? 'bg-blue-50/50' : '' }}">
                                    <p class="text-sm text-gray-800">
                                        {{-- Laravel stores data as JSON; access it like an array --}}
                                        {{ $data['message'] ?? 'New update received' }}
                                    </p>
                                    <span class="text-xs text-gray-400 italic">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            @empty
                                <div class="px-4 py-3 text-gray-500 text-sm text-center">
                                    No notifications yet.
                                </div>
                            @endforelse
                        </div>
                        
                        @if($headerNotifications->count() > 0)
                            <a href="{{route('admin.users.index')}}" class="block py-2 text-center text-xs text-blue-600 border-t hover:bg-gray-50">View All</a>
                        @endif
                    </div>
                </div>

                <!-- User Dropdown -->
                <div class="relative">
                    <button id="user-menu-button" class="flex items-center gap-2 text-white focus:outline-none">
                        <img src="{{ asset('admin/images/user-avatar.png') }}" 
                             alt="User Avatar" class="h-8 w-8 rounded-full">
                         {{ auth()->user()->name ?? 'Guest' }}
                        <i class="fa fa-chevron-down text-sm"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="user-menu" class="hidden absolute right-0 mt-2 w-40 bg-white text-gray-900 rounded shadow-lg py-2">
                        <a href="{{ route('admin.users.show', ['id' => auth()->user()->id]) }}" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
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
