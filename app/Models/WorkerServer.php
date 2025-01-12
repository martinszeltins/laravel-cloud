<?php

namespace App\Models;

use App\Jobs\ProvisionWorkerServer;
use App\Scripts;
use Carbon\Carbon;
use Illuminate\Support\Str;

class WorkerServer extends Server
{
    /**
     * Determine if this server processes queued jobs.
     *
     * @return bool
     */
    public function isWorker()
    {
        return true;
    }

    /**
     * Determine if this server is the "master" worker for the stack.
     *
     * @return bool
     */
    public function isMasterWorker()
    {
        return $this->is($this->stack->masterWorker());
    }

    /**
     * Determine if this server will run a given deployment command.
     *
     * @param  string  $command
     * @return bool
     */
    public function runsCommand($command)
    {
        return ! Str::startsWith($command, 'web:');
    }

    /**
     * Dispatch the job to provision the server.
     *
     * @return void
     */
    public function provision()
    {
        ProvisionWorkerServer::dispatch($this);

        $this->update(['provisioning_job_dispatched_at' => Carbon::now()]);
    }

    /**
     * Get the provisioning script for the server.
     *
     * @return \App\Scripts\Script
     */
    public function provisioningScript()
    {
        return new Scripts\ProvisionWorkerServer($this);
    }
}
