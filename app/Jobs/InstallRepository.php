<?php

namespace App\Jobs;

use App\Models\Stack;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InstallRepository implements ShouldQueue
{
    use Dispatchable, HandlesStackProvisioningFailures, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The stack instance.
     *
     * @var \App\Models\Stack
     */
    public $stack;

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
        $this->stack->deployBranch(
            $this->stack->meta['initial_branch'],
            $this->stack->meta['initial_build_commands'],
            $this->stack->meta['initial_activation_commands'],
            $this->stack->meta['initial_directories'],
            $this->stack->meta['initial_daemons'] ?? [],
            $this->stack->meta['initial_schedule'] ?? []
        );
    }
}
