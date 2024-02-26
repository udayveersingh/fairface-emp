<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PusherBroadcast implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public string $message;
    public string $to_id;
    public string $from_id;

    public function __construct(string $message ,string $to_id, string $from_id)
    {
        $this->message = $message;
        $this->to_id = $to_id;
        $this->from_id = $from_id;
    }

    public function broadcastOn(): array
    {
        return ['public'];
    }

    public function broadcastAs(): string
    {
        return 'chat';
    }
}
