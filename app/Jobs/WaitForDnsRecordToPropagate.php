<?php

namespace App\Jobs;

use App\Contracts\DnsProvider;
use App\Models\Stack;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class WaitForDnsRecordToPropagate implements ShouldQueue
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
    public $tries = 12; // 3 Total Minutes...

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
     * @param  \App\Contracts\DnsProvider  $dns
     * @return void
     */
    public function handle(DnsProvider $dns)
    {
        if (! $dns->propagated($this->stack)) {
            return $this->release(15);
        }
    }
}
