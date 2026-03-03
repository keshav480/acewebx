@extends('admin.layouts.app')
@section('content')
<div class="h-[calc(100vh-120px)] bg-gray-100">
    <div class="max-w-8xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden flex h-full">
        {{-- Sidebar --}}
        <div class="w-1/3 border-r bg-gray-50 flex flex-col">
            <div class="p-4 border-b">
                <h2 class="text-xl font-semibold text-gray-800">Chats</h2>
                <input type="text"
                    placeholder="Search..."
                    class="mt-3 w-full px-4 py-2 rounded-lg border focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm">
            </div>
            <div class="flex-1 overflow-y-auto">
                @foreach($userdata as $id => $name)
                @php
                $active = request()->route('id') == $id;
                @endphp
                <a href="{{ route('admin.chat.show', $id) }}">
                    <div class="flex items-center gap-3 p-4 cursor-pointer transition
                  {{ $active 
                    ? 'bg-blue-100  border-blue-500 shadow-sm' 
                    : 'hover:bg-gray-100' }}">
                        <img src="https://i.pravatar.cc/40?img={{ $id }}"
                            class="w-10 h-10 rounded-full">

                        <div class="flex-1">
                            <h4 class="font-medium {{ $active ? 'text-blue-700' : 'text-gray-800' }}">
                                {{ $name }}
                            </h4>

                            <p class="text-sm text-gray-500 truncate">
                                Last message preview...
                            </p>
                             <p class="text-sm text-green-500">Online</p>
                        </div>

                    </div>
                </a>
                @endforeach
            </div>
        </div>
        {{-- Chat Area --}}
        <div class="flex-1 flex flex-col">

            {{-- Header --}}
            <div class="p-4 border-b flex items-center gap-3">
                <img src="https://i.pravatar.cc/40"
                    class="w-10 h-10 rounded-full">
                <div>
                    <h3 class="font-semibold text-gray-800">{{ $user->name }}</h3>
                    <p class="text-sm text-green-500">Online</p>
                </div>
            </div>

            {{-- Messages --}}
            <div class="flex-1 p-6 overflow-y-auto space-y-4 bg-gray-50">

                {{-- Incoming --}}
                <div class="flex items-start gap-2">
                    <div class="bg-white px-4 py-2 rounded-2xl shadow text-sm max-w-xs">
                        Hello! How are you?
                    </div>
                </div>

                {{-- Outgoing --}}
                <div class="flex justify-end">
                    <div class="bg-blue-500 text-white px-4 py-2 rounded-2xl shadow text-sm max-w-xs">
                        I'm good! What about you?
                    </div>
                </div>

                {{-- Incoming --}}
                <div class="flex items-start gap-2">
                    <div class="bg-white px-4 py-2 rounded-2xl shadow text-sm max-w-xs">
                        I'm doing great! 🚀
                    </div>
                </div>

            </div>

            {{-- Message Input --}}
            <div class="p-4 border-t bg-white">
                <form class="flex items-center gap-3">

                    <input type="text"
                        placeholder="Type your message..."
                        class="flex-1 px-4 py-2 rounded-full border focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm">

                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-full transition">
                        Send
                    </button>

                </form>
            </div>

        </div>

    </div>

</div>

@endsection