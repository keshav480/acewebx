<!DOCTYPE html>
<html>
<head>
     <title>@yield('title', 'Acewebx')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('public/images/favicon.ico') }}"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>
    @include('public.components.header') 

    <main>
        @yield('content') 
    </main>

    @include('public.components.footer')
</body>
</html>
