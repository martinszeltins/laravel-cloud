<?php

namespace App\Callbacks;

use App\Models\Task;

class MarkAsProvisioned
{
    /**
     * Handle the callback.
     *
     * @param  Task  $task
     * @return void
     */
    public function handle(Task $task)
    {
        if ($task->provisionable) {
            $task->provisionable->markAsProvisioned();
        }
    }
}
