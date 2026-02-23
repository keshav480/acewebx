@extends('admin.layouts.app')

@section('content')
<div class="p-6">

    <!-- Page Title & Add Button -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Pages</h2>
        <a href="{{ route('admin.pages.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
           Add New Page
        </a>
    </div>

    <!-- Search Form -->
    <form method="GET" action="{{ route('admin.pages.index') }}" class="flex gap-2 mb-6">
        <input type="text" name="search" value="{{ request('search') }}" 
               placeholder="Search title or slug..."
               class="border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Search
        </button>
        @if(request('search'))
            <a href="{{ route('admin.pages.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Reset
            </a>
        @endif
    </form>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Pages Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pages as $page)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            {{ $loop->iteration + ($pages->currentPage() - 1) * $pages->perPage() }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $page->title }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $page->slug }}</td>
                        <td class="px-6 py-4 text-gray-600 capitalize">{{ $page->status }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $page->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 space-x-2">
                            <a href="{{ route('admin.pages.edit', $page->id) }}"
                               class="px-3 py-1 bg-yellow-500 text-white text-sm rounded hover:bg-yellow-600">
                               Edit
                            </a>
                            <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-6 text-gray-500">
                            No pages found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $pages->links() }}
    </div>

</div>
@endsection
