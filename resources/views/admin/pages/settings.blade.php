@extends('admin.layouts.app')

@section('content')

<div class="p-4 sm:p-6 lg:p-8">
@if(session('success'))
    <div id="message"
        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 transition-opacity duration-500 message">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 message">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <!-- Page Title -->
<form action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
<div class="flex justify-between max-w-8xl mx-auto px-6 py-4">
    <div class="flex items-center gap-4">
        <h1 class="text-2xl font-bold mb-6">Settings</h1>
    </div>
    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        Save
    </button>
</div>
    <!-- Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 4: System Settings -->
        <div class="bg-white shadow-lg rounded-xl p-6 border">
            <h2 class="text-lg font-semibold mb-4">System Settings</h2>
            <div class="space-y-4">
                <!-- Site URL -->
                <div>
                    <label class="block text-sm font-medium">Site URL</label>
                    <input type="text" name="site_url" class="w-full border rounded-lg p-2 mt-1" 
                        value="{{ old('site_url', $settings['site_url'] ?? '') }}">
                </div>

                <!-- Site Title -->
                <div>
                    <label class="block text-sm font-medium">Site Title</label>
                    <input type="text" name="site_title" class="w-full border rounded-lg p-2 mt-1" 
                        value="{{ old('site_title', $settings['site_title'] ?? '') }}">
                </div>

                <!-- Site Logo -->
                    <div>
                        <label class="block text-sm font-medium">Site Logo</label>
                        <input type="file" id="site_logo" name="site_logo" class="w-full border rounded-lg p-2 mt-1" accept="image/*" onchange="previewImage(event, 'logo_preview','remove_site_logo')">

                        <!-- Hidden remove flag -->
                        <input type="hidden" name="remove_site_logo" id="remove_site_logo" value="0">

                        <!-- Preview -->
                        <div id="logo_preview" class="mt-2 relative w-32 h-32 {{ empty($settings['site_logo']) ? 'hidden' : '' }}">
                            <img id="logo_img" src="{{ !empty($settings['site_logo']) ? asset('storage/' . $settings['site_logo']) : '' }}" alt="Site Logo" class="w-full h-full object-contain rounded">
                            <button type="button" onclick="removeImage('site_logo','logo_preview','remove_site_logo')" class="absolute top-0 right-0 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center">
                                &times;
                            </button>
                        </div>
                    </div>
                <!-- Favicon -->
                   <div>
                    <label class="block text-sm font-medium">Favicon</label>
                    <input type="file" id="favicon" name="favicon" class="w-full border rounded-lg p-2 mt-1" accept="image/*" onchange="previewImage(event, 'favicon_preview','remove_favicon')">

                    <!-- Hidden remove flag -->
                    <input type="hidden" name="remove_favicon" id="remove_favicon" value="0">

                    <!-- Preview Container -->
                    <div id="favicon_preview" class="mt-2 relative w-16 h-16 {{ empty($settings['favicon']) ? 'hidden' : '' }}">
                        <img id="favicon_img" src="{{ !empty($settings['favicon']) ? asset('storage/' . $settings['favicon']) : '' }}" 
                            alt="Favicon" class="w-full h-full object-contain rounded">
                        <!-- Corrected: pass remove_favicon as third argument -->
                        <button type="button" onclick="removeImage('favicon','favicon_preview','remove_favicon')" 
                                class="absolute top-0 right-0 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center">
                            &times;
                        </button>
                    </div>
                </div>

            </div>
        </div>
        <div class="bg-white shadow-lg rounded-xl p-6 border">
            <h2 class="text-lg font-semibold mb-4">SMTP Settings</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium">SMTP Host</label>
                    <input type="text" name="smtp_host" class="w-full border rounded-lg p-2 mt-1"value="{{ old('smtp_host', $settings['smtp_host'] ?? '') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium">SMTP Port</label>
                    <input type="text" name="smtp_port" class="w-full border rounded-lg p-2 mt-1" value="{{ old('smtp_port', $settings['smtp_port'] ?? '') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium">Username</label>
                    <input type="text" name="smtp_username" class="w-full border rounded-lg p-2 mt-1" value="{{ old('smtp_username', $settings['smtp_username'] ?? '') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium">Password</label>
                    <input type="password" name="smtp_password" class="w-full border rounded-lg p-2 mt-1" value="{{ old('smtp_password', $settings['smtp_password'] ?? '') }}">
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white shadow-lg rounded-xl p-4 border">
            <h2 class="text-lg font-semibold mb-4">Email Settings</h2>
            <p class="text-gray-600">Add your email configuration here.</p>
        </div>

        <!-- Card 3 -->
        <div class="bg-white shadow-lg rounded-xl p-4 border">
            <h2 class="text-lg font-semibold mb-4">Notification Settings</h2>
            <p class="text-gray-600">Manage notification preferences.</p>
        </div>

    
    </div>

    </div>
</form>
<script>
function previewImage(event, previewId, removeFlagId) {
    const input = event.target;
    const previewContainer = document.getElementById(previewId);
    const img = previewContainer.querySelector('img');
    const removeFlag = document.getElementById(removeFlagId);

    if (!removeFlag) return; // Safety check

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            previewContainer.classList.remove('hidden');
            removeFlag.value = '0'; // reset flag if new file selected
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function removeImage(inputId, previewId, removeFlagId) {
    const input = document.getElementById(inputId);
    const previewContainer = document.getElementById(previewId);
    const img = previewContainer.querySelector('img');
    const removeFlag = document.getElementById(removeFlagId);

    if (!removeFlag) return; // Safety check

    input.value = '';
    img.src = '';
    previewContainer.classList.add('hidden');
    removeFlag.value = '1'; // mark for deletion
}


</script>

@endsection
