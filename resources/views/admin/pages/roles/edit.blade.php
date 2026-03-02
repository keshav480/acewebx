@extends('admin.layouts.app')

@section('content')
<div class="max-w-8xl mx-auto p-6">

    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Edit Role</h1>

        <a href="{{ route('admin.roles.index') }}"
            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
            Back to Roles
        </a>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="lg:flex lg:space-x-6">

            <!-- LEFT SIDE -->
            <div class="flex-1 space-y-6">

                <!-- Role Name -->
                <div class="bg-white border border-gray-200 rounded shadow p-6">
                    <label class="block text-gray-700 font-medium mb-2">Role Name</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $role->name) }}"
                        required
                        class="w-full border rounded px-3 py-2 focus:ring-2 focus:ring-blue-500"
                    >
                </div>

                <!-- Permissions -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6">
                    <label class="block text-lg font-semibold text-gray-800 mb-4">
                        Assign Permissions
                    </label>

                    <div class="space-y-6">
                        @foreach(config('menu.items') as $index => $item)
                        <div class="border rounded-lg bg-gray-50 overflow-hidden">

                            <!-- Group Header -->
                            <div class="flex items-center justify-between p-4 hover:bg-gray-100">
                                <div class="flex items-center gap-3">
                                    <!-- Parent Checkbox -->
                                    <input
                                        type="checkbox"
                                        id="parent-perm{{ $index }}"
                                        onclick="toggleAllPermissions(this, '{{ $index }}')"
                                        class="w-5 h-5"
                                    >
                                    <!-- Toggle collapse -->
                                    <button
                                        type="button"
                                        onclick="togglePermission('perm{{ $index }}')"
                                        class="font-semibold text-gray-700"
                                    >
                                        {{ $item['title'] }}
                                    </button>
                                </div>

                                <span id="icon-perm{{ $index }}">+</span>
                            </div>

                            <!-- Permission List -->
                            <div id="perm{{ $index }}" class="hidden border-t p-4 space-y-3">
                                @foreach($item['permissions'] ?? [] as $permission)
                                <label class="flex items-center bg-white border rounded-lg px-4 py-3 hover:bg-blue-50">
                                    <input
                                        type="checkbox"
                                        name="permissions[]"
                                        value="{{ $permission }}"
                                        class="child-perm-{{ $index }} w-4 h-4 mr-3"
                                        {{ in_array($permission, $rolePermissions) ? 'checked' : '' }}
                                    >
                                    {{ ucfirst($permission) }}
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- RIGHT SIDE -->
            <div class="w-full lg:w-1/4 space-y-6">
                <div class="bg-white border border-gray-200 rounded shadow p-4">
                    <h2 class="font-semibold text-gray-700 mb-2">Update</h2>
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Update Role
                    </button>
                </div>
            </div>

        </div>
    </form>
</div>

<script>
    // Toggle collapse
    function togglePermission(id) {
        const el = document.getElementById(id);
        const icon = document.getElementById('icon-' + id);
        if (!el || !icon) return;
        el.classList.toggle('hidden');
        icon.innerText = el.classList.contains('hidden') ? "+" : "−";
    }

    // Parent toggles all children
    function toggleAllPermissions(parent, index) {
        const children = document.querySelectorAll('.child-perm-' + index);
        children.forEach(child => child.checked = parent.checked);
    }

    // Update parent if any child is checked
    function updateParentCheckbox(index) {
        const children = document.querySelectorAll('.child-perm-' + index);
        const parent = document.getElementById('parent-perm' + index);
        if (!parent || children.length === 0) return;

        parent.checked = Array.from(children).some(c => c.checked);
    }

    // On page load
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('[id^="parent-perm"]').forEach(parent => {
            const index = parent.id.replace('parent-perm','');

            // check parent based on children
            updateParentCheckbox(index);

            // watch child changes
            document.querySelectorAll('.child-perm-' + index)
                .forEach(child => {
                    child.addEventListener('change', () => updateParentCheckbox(index));
                });
        });
    });
</script>
@endsection
