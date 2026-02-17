<!DOCTYPE html>
<html>
<head>
     <title>@yield('title', 'Acewebx')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('public/images/favicon.ico') }}"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
</body>
</html>
