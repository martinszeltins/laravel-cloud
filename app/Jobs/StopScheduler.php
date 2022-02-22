<?php

namespace App\Jobs;

use App\Models\ServerDeployment;
use App\Scripts\StopScheduler as StopSchedulerScript;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StopScheduler implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The server deployment instance.
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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (empty($this->deployment->schedule())) {
            return $this->delete();
        }

        if ($this->deployment->deployable->isWorker()) {
            $this->deployment->deployable->runInBackground(
                new StopSchedulerScript($this->deployment)
            );
        }
    }
}
