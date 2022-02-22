<?php

namespace App\Events;

use App\Models\DatabaseRestore;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DatabaseRestoreRunning
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The database restore instance.
     *
     * @var \App\Models\DatabaseRestore
     */
    public $restore;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\DatabaseRestore $restore
     *
     * @return void
     */
    public function __construct(DatabaseRestore $restore)
    {
        $this->restore = $restore;
    }
}
