<?php

namespace App\Events;

use App\Models\Number;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NumberAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Number $number;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Number $number)
    {
        $this->number = $number;
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
