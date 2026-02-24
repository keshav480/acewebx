<!DOCTYPE html>
<html>
<head>
     <title>{{ seo_meta('meta_title') ?? site_title() }}</title>
    <meta name="description" content="{{ seo_meta('meta_description') ?? 'Default description' }}">
    <meta name="keywords" content="{{ seo_meta('meta_keywords') ?? 'keyword1, keyword2' }}">
    <link rel="icon" type="image/x-icon" href=" {{ favicon() }}"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <meta name="user-id" content="{{ auth()->id() }}">

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
