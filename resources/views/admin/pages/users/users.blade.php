@extends('admin.layouts.app')

@section('content')

<div class="p-6">
    
    <!-- Page Title -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Users</h1>
     <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-2">

        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Search name or email..."
               class="border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Search
        </button>

        {{-- Reset Button --}}
        @if(request('search'))
            <a href="{{ route('admin.users.index') }}"
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Reset
            </a>
        @endif

    </form>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">

                <!-- Table Header -->
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                         <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                        <!-- <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th> -->
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="bg-white divide-y divide-gray-200">

                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">
                           <a href="{{ route('admin.users.show', ['id' => $user->id]) }}">
                            {{ $user->name }}
                            </a>
                        </td>
                          <td class="px-6 py-4 text-gray-600">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                          {{ $user->role }}
                        </td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ $user->created_at->format('d M Y') }}
                        </td>

                        <!-- Status -->
                        <!-- <td class="px-6 py-4">
                            @if($user->email_verified_at)
                                <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded">
                                    Active
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded">
                                    Pending
                                </span>
                            @endif
                        </td> -->

                        <!-- Actions -->
                        <td class="px-6 py-4 space-x-2">
                            <a href="{{ route('admin.users.show', ['id' => $user->id]) }}"class="px-3 py-1 bg-yellow-500 text-white text-sm rounded hover:bg-yellow-600">
                                Edit
                            </a>
                            <button class="px-3 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600">
                                Delete
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-6 text-gray-500">
                            No users found
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $users->links() }}
    </div>

</div>

@endsection
