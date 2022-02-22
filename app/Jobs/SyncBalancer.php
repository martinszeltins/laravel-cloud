<?php

namespace App\Jobs;

use App\Models\Balancer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncBalancer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The balancer instance.
     *
     * @var \App\Models\Balancer
     */
    public $balancer;

    /**
     * Delete this job if any injected models are missing.
     *
     * @var bool
     */
    protected $deleteWhenMissingModels = true;

    /**
     * Create a new job instance.
     *
     * @param  Balancer  $balancer
     * @return void
     */
    public function __construct(Balancer $balancer)
    {
        $this->balancer = $balancer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->balancer->syncNow();
    }
}
