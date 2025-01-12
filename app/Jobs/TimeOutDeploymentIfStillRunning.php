<?php

namespace App\Jobs;

use App\Models\Deployment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TimeOutDeploymentIfStillRunning implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The deployment ID.
     *
     * @var \App\Models\Deployment
     */
    public $deployment;

    /**
     * Delete this job if any injected models are missing.
     *
     * @var bool
     */
    protected $deleteWhenMissingModels = true;

    /**
     * Create a new job instance.
     *
     * @param  \App\Models\Deployment $deployment
     *
     * @return void
     */
    public function __construct(Deployment $deployment)
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
        if (! $this->deployment->hasEnded()) {
            $this->deployment->markAsTimedOut();
        }
    }
}
