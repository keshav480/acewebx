@extends('admin.layouts.app')

@section('content')
<div class="h-[calc(100vh-120px)] bg-gray-100">
    <div class="max-w-8xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden flex h-full">

        {{-- ================= SIDEBAR ================= --}}
        <div class="w-1/3 border-r bg-gray-50 flex flex-col">
            <div class="p-4 border-b">
                <h2 class="text-xl font-semibold text-gray-800">Chats</h2>
            </div>

            <div class="flex-1 overflow-y-auto">
                @foreach($userdata as $id => $name)
                    @php
                        $active = request()->route('id') == $id;
                    @endphp

                    <a href="{{ route('admin.chat.show', $id) }}">
                        <div class="flex items-center gap-3 p-4 cursor-pointer transition
                            {{ $active 
                                ? 'bg-blue-100 border-l-4 border-blue-500 shadow-sm' 
                                : 'hover:bg-gray-100' }}">
                            
                            <img src="https://i.pravatar.cc/40?img={{ $id }}"
                                 class="w-10 h-10 rounded-full">

                            <div class="flex-1">
                                <h4 class="font-medium 
                                    {{ $active ? 'text-blue-700' : 'text-gray-800' }}">
                                    {{ $name }}
                                </h4>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- ================= CHAT AREA ================= --}}
        <div class="flex-1 flex flex-col">

            @if(isset($user))

                {{-- Header --}}
                <div class="p-4 border-b flex items-center gap-3">
                    <img src="https://i.pravatar.cc/40?img={{ $user->id }}"
                         class="w-10 h-10 rounded-full">

                    <div>
                        <h3 class="font-semibold text-gray-800">
                            {{ $user->name }}
                        </h3>
                    </div>
                </div>

                {{-- Messages --}}
                <div id="messages"
                     class="flex-1 p-6 overflow-y-auto space-y-4 bg-gray-50">

                    @foreach($messages ?? [] as $message)

                        @if($message->sender_id == auth()->id())
                            {{-- Outgoing --}}
                            <div class="flex justify-end">
                                <div class="bg-blue-500 text-white px-4 py-2 rounded-2xl shadow text-sm max-w-xs">
                                    {{ $message->body }}
                                </div>
                            </div>
                        @else
                            {{-- Incoming --}}
                            <div class="flex items-start gap-2">
                                <div class="bg-white px-4 py-2 rounded-2xl shadow text-sm max-w-xs">
                                    {{ $message->body }}
                                </div>
                            </div>
                        @endif

                    @endforeach
                </div>

                {{-- Message Input --}}
                <div class="p-4 border-t bg-white">
                    <form id="chatForm" class="flex items-center gap-3">
                        @csrf
                        <input id="messageInput"
                               type="text"
                               placeholder="Type your message..."
                               class="flex-1 px-4 py-2 rounded-full border focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm">

                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-full transition">
                            Send
                        </button>
                    </form>
                </div>
                @else
                <div class="flex items-center justify-center h-full text-gray-400">
                    Select a chat to start messaging
                </div>

            @endif

        </div>
    </div>
</div>
@endsection


{{-- ================= SCRIPTS ================= --}}
@if(isset($user))
<script>

document.addEventListener("DOMContentLoaded", function () {

    let form = document.getElementById('chatForm');
    let input = document.getElementById('messageInput');
    let messages = document.getElementById('messages');

    // Auto scroll on load
    messages.scrollTop = messages.scrollHeight;

    // SEND MESSAGE
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        let message = input.value.trim();
        if(message === '') return;

        fetch("{{ route('admin.chat.send') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                receiver_id: "{{ $user->id }}",
                body: message
            })
        });

        // Show instantly (optimistic UI)
        let html = `
            <div class="flex justify-end">
                <div class="bg-blue-500 text-white px-4 py-2 rounded-2xl shadow text-sm max-w-xs">
                    ${message}
                </div>
            </div>
        `;

        messages.insertAdjacentHTML('beforeend', html);
        messages.scrollTop = messages.scrollHeight;

        input.value = '';
    });


    // REALTIME LISTENER (Reverb)
    let userId = "{{ auth()->id() }}";

    window.Echo.private('chat.' + userId)
        .listen('MessageSent', (e) => {

            let html = `
                <div class="flex items-start gap-2">
                    <div class="bg-white px-4 py-2 rounded-2xl shadow text-sm max-w-xs">
                        ${e.message.body}
                    </div>
                </div>
            `;

            messages.insertAdjacentHTML('beforeend', html);
            messages.scrollTop = messages.scrollHeight;
        });

});
</script>
@endif
