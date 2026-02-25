@extends('public.layouts.app')
@section('content')
@if($page)
    <div class="max-w-7xl mx-auto px-6 py-12">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6 text-center">
            {{ $page->title }}
        </h1>
        <div class="prose prose-lg mx-auto text-gray-700">
         {!! \App\Helpers\ShortcodeManager::parse($page->content) !!}
        </div>
    </div>
@else
    <div class="text-center py-20">
        <h1 class="text-5xl font-bold text-red-600">404</h1>
        <p class="text-xl mt-4 text-gray-600">Oops! Page not found.</p>
        <a href="/" class="mt-6 inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
            Back to Home
        </a>
    </div>
@endif
@endsection
