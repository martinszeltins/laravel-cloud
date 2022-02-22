<?php

namespace App\Events;

use App\Models\StackTask;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StackTaskFinished
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The stack task instance.
     *
     * @var \App\Models\StackTask
     */
    public $task;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\StackTask $task
     *
     * @return void
     */
    public function __construct(StackTask $task)
    {
        $this->task = $task;
    }
}
