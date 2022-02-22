<?php

namespace App\Jobs;

use App\Exceptions\StackProvisioningTimeout;
use App\Models\Stack;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class WaitForServersToFinishProvisioning implements ShouldQueue
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
    public $tries = 50; // 25 Total Minutes...

    /**
     * Create a new job instance.
     *
     * @param  \App\Models\Stack $stack
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
        if (count($this->stack->allServers()) !== $this->stack->initial_server_count) {
            return $this->fail(new StackProvisioningTimeout($this->stack));
        } elseif ($this->stack->serversAreProvisioned() && $this->balancerIsProvisioned()) {
            return $this->delete();
        } elseif ($this->stack->olderThan(20)) {
            return $this->fail(new StackProvisioningTimeout($this->stack));
        }

        $this->release(30);
    }

    /**
     * Determine if the project has a provisioned load balancer.
     *
     * @return bool
     */
    protected function balancerIsProvisioned()
    {
        $balancers = $this->stack->environment->project->balancers;

        return count($balancers) > 0 ? $balancers->contains->isProvisioned() : true;
    }
}
