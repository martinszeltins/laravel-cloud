<?php

namespace App\Callbacks;

use App\Models\ServerDeployment;
use App\Models\Task;

class CheckActivation
{
    /**
     * The server deployment ID.
     *
     * @var int
     */
    public $id;

    /**
     * Create a new callback instance.
     *
     * @param  int  $id
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Handle the callback.
     *
     * @param  Task  $task
     * @return void
     */
    public function handle(Task $task)
    {
        if ($deployment = ServerDeployment::find($this->id)) {
            $task->successful()
                    ? $deployment->markAsActivated()
                    : $deployment->markAsFailed();
        }
    }
}
