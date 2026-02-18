<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewUserRegisteredNotification extends Notification
{
    use Queueable;

    protected $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Notification channels
     */
    public function via($notifiable)
    {
        // database = store in DB
        // broadcast = realtime notification
        return ['database', 'broadcast'];
    }

    /**
     * Store notification in database
     */
    public function toArray($notifiable)
    {
        return [
            'message' => $this->message
        ];
    }

    /**
     * Realtime broadcast
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => $this->message
        ]);
    }
}
