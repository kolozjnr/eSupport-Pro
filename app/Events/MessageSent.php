<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(Message $message)
    {
        if (!$message instanceof Message) {
        \Log::error('MessageSent event received invalid message type: ' . gettype($message));
        throw new \InvalidArgumentException('MessageSent event requires a Message model instance');
        }
    
        $this->message = $message->load('user');
    }

    public function broadcastOn()
    {
        return new PrivateChannel('conversation.' . $this->message->conversation_id);
    }

    public function broadcastAs()
    {
        return 'new-message';
    }

    public function broadcastWith()
    {
        return [
            'message' => [
                'id' => $this->message->id,
                'content' => $this->message->content,
                'type' => $this->message->type,
                'attachments' => $this->message->attachments,
                'user_id' => $this->message->user_id,
                //'is_mine' => false,
                'formatted_time' => $this->message->created_at->format('H:i'),
                'read_at' => $this->message->read_at,
                'created_at' => $this->message->created_at,
            ],
            'conversation_id' => $this->message->conversation_id,
        ];
    }
}