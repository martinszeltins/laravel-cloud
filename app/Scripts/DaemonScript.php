<?php

namespace App\Scripts;

use App\Models\ServerDeployment;

abstract class DaemonScript extends Script
{
    /**
     * The deployment instance.
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
     * Get the name of the script to run.
     *
     * @return string
     */
    abstract public function scriptName();

    /**
     * Get the contents of the script.
     *
     * @return string
     */
    public function script()
    {
        return view($this->scriptName(), [
            'script' => $this,
            'generation' => $this->deployment->currentDaemonGeneration(),
        ])->render();
    }
}
