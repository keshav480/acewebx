@extends('admin.layouts.app')

@section('content')

<div class="p-6 space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-800">Media Library</h1>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="px-4 py-3 text-green-700 bg-green-100 border border-green-200 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- Upload Box --}}
    <div class="p-6 bg-white shadow rounded-xl">
        <form action="{{ route('admin.media.upload') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-4">
            @csrf

            <input 
                type="file" 
                name="file" 
                required
                class="block w-full text-sm text-gray-600
                file:mr-4 file:py-2 file:px-4
                file:rounded-lg file:border-0
                file:text-sm file:font-semibold
                file:bg-blue-50 file:text-blue-700
                hover:file:bg-blue-100"
            >

            <button 
                type="submit"
                class="px-5 py-2 font-medium text-white transition bg-blue-600 rounded-lg hover:bg-blue-700"
            >
                Upload
            </button>
        </form>
    </div>

    {{-- Media Grid --}}
    <div class="grid grid-cols-2 gap-6 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">

        @forelse($files as $file)
            <div class="relative overflow-hidden bg-white shadow rounded-xl group">

                {{-- Image --}}
                <img 
                    src="{{ asset('storage/' . $file) }}"
                    class="object-cover w-full h-40"
                >

                {{-- Hover Overlay --}}
                <div class="absolute inset-0 flex items-center justify-center transition bg-black/50 opacity-0 group-hover:opacity-100">

                    <form action="{{ route('admin.media.delete', basename($file)) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button 
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700"
                        >
                            Delete
                        </button>
                    </form>

                </div>

            </div>
        @empty
            <p class="col-span-full text-center text-gray-500">
                No media found.
            </p>
        @endforelse

    </div>

</div>

@endsection
