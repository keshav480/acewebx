@extends('admin.layouts.app')

@section('content')

<div class="p-6">
       <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Role List</h1>

        <a href="{{ route('admin.roles.create') }}"
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow">
            + Create New Role
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 border-b">
                        ID
                    </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 border-b">
                        Role Name
                    </th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700 border-b">
                        Created At
                    </th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700 border-b">
                        Action
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($roles as $role)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $role->id }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $role->name }}
                        </td>

                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $role->created_at->format('d M Y') }}
                        </td>

                        <td class="px-6 py-4 text-center">
                           <a href="{{ route('admin.roles.edit', $role->id) }}"
                                class="text-blue-500 hover:text-blue-700 mr-3">
                                Edit
                            </a>
                           <form action="{{ route('admin.roles.destroy', $role->id) }}"
                                method="POST"
                                class="inline-block"
                                onsubmit="return confirm('Are you sure you want to delete this role?');">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-500">
                            No roles found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
