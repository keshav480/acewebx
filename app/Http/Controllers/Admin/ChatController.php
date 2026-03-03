<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ChatService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function index()
    {
        $userdata = User::where('id', '!=', auth()->id())->pluck('name', 'id');
        return view('admin.pages.chat.index', compact('userdata'));
    }

    public function show($id)
    {
        $userdata = User::where('id', '!=', auth()->id())->pluck('name', 'id');
        $user = User::select('id', 'name')->findOrFail($id);
        $messages = $this->chatService->conversation(auth()->id(), $id);
        return view('admin.pages.chat.index', 
            compact('userdata', 'user', 'messages')
        );
    }
    private function chatUsers()
    {
        return User::whereKeyNot(auth()->id())->pluck('name', 'id');
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'body' => 'required|string'
        ]);

        $message = $this->chatService->send(
            auth()->id(),
            $request->receiver_id,
            $request->body
        );

        return response()->json($message);
    }
}
