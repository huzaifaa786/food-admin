<?php

namespace App\Events;

use App\Models\OrderLocation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class OrderLocationChangeEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public OrderLocation $location;
    /**
     * Create a new event instance.
     */
    public function __construct(OrderLocation $location)
    {
        Log::info('eejeklrlkwrj');

        $this->location = $location;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        Log::info('yahan a raha ha');
        return [
            new Channel('order-location-' . $this->location->order_id),
        ];
    }
}
