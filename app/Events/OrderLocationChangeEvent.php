<?php

namespace App\Events;

use App\Models\OrderLocation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class OrderLocationChangeEvent
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
        return [
            new Channel('order-location'),
        ];
    }
}
