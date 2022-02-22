<?php

namespace App\Scripts;

use App\Models\ServerTask;

class RunServerTask extends Script
{
    /**
     * The task instance.
     *
     * @var \App\Models\ServerTask
     */
    public $task;

    /**
     * The user that the script should be run as.
     *
     * @var string
     */
    public $sshAs;

    /**
     * Create a new script instance.
     *
     * @param  \App\Models\ServerTask $task
     *
     * @return void
     */
    public function __construct(ServerTask $task)
    {
        $this->task = $task;
        $this->sshAs = $task->stackTask->user;
    }

    /**
     * Get the name of the script.
     *
     * @return string
     */
    public function name()
    {
        return "Running Server Task";
    }

    /**
     * Get the contents of the script.
     *
     * @return string
     */
    public function script()
    {
        return implode(PHP_EOL, $this->task->commands);
    }

    /**
     * Get the timeout for the script.
     *
     * @return int|null
     */
    public function timeout()
    {
        return 60 * 60;
    }
}
