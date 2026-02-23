@extends('admin.layouts.app')

@section('content')
<div class="max-w-8xl mx-auto p-6">

    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Create New Page</h1>
        <a href="{{ route('admin.pages.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
           Back to Pages
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.pages.store') }}" method="POST">
        @csrf
        <div class="lg:flex lg:space-x-6 ">

            <!-- Left Column (Main Content) -->
            <div class="flex-1 space-y-6 lg:mr-6">

                <!-- Title Meta Box -->
                <div class="bg-white border border-gray-200 rounded shadow p-6">
                    <label for="title" class="block text-gray-700 font-medium mb-2">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Content Meta Box -->
                <div class="bg-white border border-gray-200 rounded shadow p-6">
                    <label for="content" class="block text-gray-700 font-medium mb-2">Content</label>
                    <textarea name="content" id="content" rows="15"
                              class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('content') }}</textarea>
                </div>

            </div>

            <!-- Right Column (Sidebar) -->
            <div class="w-full lg:w-1/4 space-y-6">

                <!-- Publish Box -->
                <div class="bg-white border border-gray-200 rounded shadow p-4">
                    <h2 class="font-semibold text-gray-700 mb-2">Publish</h2>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Status</label>
                        <select name="status" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Publish
                    </button>
                </div>

                <!-- Featured Image Box -->
                <div class="bg-white border border-gray-200 rounded shadow p-4">
                    <h2 class="font-semibold text-gray-700 mb-2">Featured Image</h2>
                    <input type="file" name="featured_image" class="w-full border rounded px-2 py-1">
                </div>

            </div>
        </div>
    </form>
</div>
@endsection
