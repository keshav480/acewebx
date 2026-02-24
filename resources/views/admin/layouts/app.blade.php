<!DOCTYPE html>
<html>
<head>
     <title>@yield('title', 'Acewebx')</title>
    <link rel="icon" type="image/x-icon" href="{{ favicon() }}"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth()->id() }}">
    <meta name="user-role" content="{{ auth()->user()->role ?? 'user' }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="flex min-h-screen">
        <x-admin.components.sidebar />

        <div class="flex-1 flex flex-col">
            @include('admin.components.header')

            <main class="flex-1">
                <div class="max-w-8xl auto px-6 py-6">
                    @yield('content')
                </div>
            </main>

            @include('admin.components.footer')
        </div>
    </div>
    
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
