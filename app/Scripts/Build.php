<?php

namespace App\Scripts;

use App\Models\ServerDeployment;

class Build extends Script
{
    /**
     * The deployment instance.
     *
     * @var \App\Models\ServerDeployment
     */
    public $deployment;

    /**
     * The user that the script should be run as.
     *
     * @var string
     */
    public $sshAs = 'cloud';

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
        return "Building Deployment ({$this->deployment->stack()->name})";
    }

    /**
     * Get the contents of the script.
     *
     * @return string
     */
    public function script()
    {
        return view('scripts.deployment.build', [
            'script' => $this,
            'deployment' => $this->deployment,
            'deployable' => $this->deployment->deployable,
            'directories' => $this->deployment->deployment->directories,
        ])->render();
    }

    /**
     * Get the timeout for the script.
     *
     * @return int|null
     */
    public function timeout()
    {
        return 20 * 60;
    }
}
