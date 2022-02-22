<?php

namespace App\Events;

use App\Contracts\Alertable;
use App\Models\Stack;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StackProvisioned implements Alertable
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The stack instance.
     *
     * @var \App\Models\Stack
     */
    public $stack;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\Stack $stack
     *
     * @return void
     */
    public function __construct(Stack $stack)
    {
        $this->stack = $stack;
    }

    /**
     * Create an alert for the given instance.
     *
     * @return \App\Models\Alert
     */
    public function toAlert()
    {
        return $this->stack->project()->alerts()->create([
            'stack_id' => $this->stack->id,
            'level' => 'success',
            'type' => 'StackProvisioned',
            'exception' => '',
            'meta' => [],
        ]);
    }
}
