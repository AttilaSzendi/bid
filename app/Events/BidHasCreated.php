<?php

namespace App\Events;

use App\Bid;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BidHasCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $bid;
    public $productId;

    public function __construct(Bid $bid, int $productId)
    {
        $this->bid = $bid;
        $this->productId = $productId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
//        public channel
//        return new Channel('bid-channel');

//        better public channel
//        return new Channel('bid-channel.'. $this->productId);

//        private channel
//        return new PrivateChannel('bid-channel.'. $this->productId);

//        presence channel
//        return new PresenceChannel('bid-channel.'. $this->productId);
    }
}
