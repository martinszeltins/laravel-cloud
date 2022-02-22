<?php

namespace App\Scripts;

use App\Models\ServerDeployment;

class StopScheduler extends Script
{
    /**
     * The server deployment.
     *
     * @var \App\Models\ServerDeployment
     */
    public $deployment;

    /**
     * Create a new script instance.
     *
     * @param  \App\Models\ServerDeployment $deployment
     *
     * @return void
     */
    public function __construct(ServerDeployment $deployment)
    {
        $this->deployment = $deployment;
    }

    /**
     * Get the name of the script.
     *
     * @return string
     */
    public function name()
    {
        return "Stopping Scheduler ({$this->deployment->deployable->name})";
    }

    /**
     * Get the contents of the script.
     *
     * @return string
     */
    public function script()
    {
        return view('scripts.scheduler.stop')->render();
    }

    /**
     * Get the timeout for the script.
     *
     * @return int|null
     */
    public function timeout()
    {
        return 15;
    }
}
