<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Angebotsevent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public string $message;
    public string $article; //name des artikels
    public int $userId;
    /**
     * Create a new event instance.
     */
    public function __construct(string $message, string $article)
    {
        $this->message = $message;
        $this->article = $article;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): Channel
    {
        return new Channel('OffersEvent');
    }

    public function broadcastAs()
    {
        return 'Offers-Event';
    }

    public function broadcastWith(): array{
        return [
            'message' => $this->message,
            'articleName' => $this->article
        ];
    }
}
