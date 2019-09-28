<?php

namespace App\Events;

use App\Commodity;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CommodityView
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $commodity;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Commodity $commodity)
    {
        $this->commodity = $commodity;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
