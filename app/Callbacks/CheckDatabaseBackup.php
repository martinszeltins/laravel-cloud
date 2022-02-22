<?php

namespace App\Callbacks;

use App\Models\DatabaseBackup;
use App\Models\Task;

class CheckDatabaseBackup
{
    /**
     * The database backup ID.
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
     * @param \App\Models\Task $task
     *
     * @return void
     */
    public function handle(Task $task)
    {
        if ($backup = DatabaseBackup::find($this->id)) {
            $backup->updateSize();

            $task->successful()
                    ? $backup->markAsFinished($task->output)
                    : $backup->markAsFailed($task->exit_code, $task->output);
        }
    }
}
