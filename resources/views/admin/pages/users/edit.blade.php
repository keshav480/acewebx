@extends('admin.layouts.app')

@section('content')

<div class="p-6 max-w-8l mx-auto">

    <h1 class="text-2xl font-bold mb-6">Edit User</h1>

    {{-- Errors --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="bg-white shadow rounded-lg p-6">

        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Name</label>
                <input type="text"
                       name="name"
                       value="{{ old('name', $user->name) }}"
                       class="w-full border p-2 rounded"
                       required>
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Email</label>
                <input type="email"
                       name="email"
                       value="{{ old('email', $user->email) }}"
                       class="w-full border p-2 rounded"
                       required>
            </div>

            {{-- Role --}}
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Role</label>
                <select name="role" class="w-full border p-2 rounded">
                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            {{-- Buttons --}}
            <div class="flex gap-3">

                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Update User
                </button>

                <a href="{{ route('admin.users.index') }}"
                   class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Back
                </a>

            </div>

        </form>

    </div>

</div>

@endsection
