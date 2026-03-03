<?php

namespace App\Services;

use App\Models\Message;
use App\Events\Chat\MessageSent;

class ChatService
{
    public function send($senderId, $receiverId, $body)
    {
        $message = Message::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'body' => $body,
        ]);

        broadcast(new MessageSent($message))->toOthers();

        return $message;
    }

    public function conversation($userId, $otherUserId)
    {
        return Message::where(function ($q) use ($userId, $otherUserId) {
                $q->where('sender_id', $userId)
                  ->where('receiver_id', $otherUserId);
            })
            ->orWhere(function ($q) use ($userId, $otherUserId) {
                $q->where('sender_id', $otherUserId)
                  ->where('receiver_id', $userId);
            })
            ->orderBy('created_at')
            ->get();
    }
}
