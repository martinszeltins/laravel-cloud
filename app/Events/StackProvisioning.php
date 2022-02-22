<?php

namespace App\Events;

use App\Models\Stack;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StackProvisioning
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The stack being provisioned.
     *
     * @var \App\Models\Stack
     */
    public $stack;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Stack $stack
     *
     * @return void
     */
    public function __construct(Stack $stack)
    {
        $this->stack = $stack;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
