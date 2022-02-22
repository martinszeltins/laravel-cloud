<?php

namespace App\Events;

use App\Models\ServerTask;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ServerTaskFailed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The server task instance.
     *
     * @var \App\Models\ServerTask
     */
    public $task;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\ServerTask $task
     *
     * @return void
     */
    public function __construct(ServerTask $task)
    {
        $this->task = $task;
    }
}
