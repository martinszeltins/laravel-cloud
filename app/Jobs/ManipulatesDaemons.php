<?php

namespace App\Jobs;

use App\Models\ServerDeployment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class ManipulatesDaemons implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The deployment instance.
     *
     * @var \App\Models\ServerDeployment
     */
    public $deployment;

    /**
     * Create a new job instance.
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
     * Get the script instance for the job.
     *
     * @return \App\Scripts\Script
     */
    abstract public function script();

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (empty($this->deployment->daemons())) {
            return $this->delete();
        }

        if ($this->deployment->deployable->isWorker()) {
            $this->deployment->deployable->runInBackground($this->script());
        }
    }
}
