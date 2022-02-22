<?php

namespace App\Jobs;

use App\Models\WorkerServer;

class ProvisionWorkerServer extends ServerProvisioner
{
    /**
     * Create a new job instance.
     *
     * @param  \App\Models\WorkerServer $provisionable
     *
     * @return void
     */
    public function __construct(WorkerServer $provisionable)
    {
        $this->provisionable = $provisionable;
    }
}
