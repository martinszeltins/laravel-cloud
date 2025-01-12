<?php

namespace App\Jobs;

use App\Models\Stack;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class WaitForStackToFinishNetworking implements ShouldQueue
{
    use Dispatchable, HandlesStackProvisioningFailures, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The stack instance.
     *
     * @var \App\Models\Stack
     */
    public $stack;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 20; // 5 Total Minutes...

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Stack $stack)
    {
        $this->stack = $stack;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (count($this->stack->databases) === 0) {
            return $this->delete();
        }

        $this->stack->databases->every->networkIsSynced()
                ? $this->delete()
                : $this->release(15);
    }
}
