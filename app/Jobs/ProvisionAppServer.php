<?php

namespace App\Jobs;

use App\Services\AppServer;

class ProvisionAppServer extends ServerProvisioner
{
    /**
     * Create a new job instance.
     *
     * @param  \App\Services\AppServer $provisionable
     *
     * @return void
     */
    public function __construct(AppServer $provisionable)
    {
        $this->provisionable = $provisionable;
    }
}
