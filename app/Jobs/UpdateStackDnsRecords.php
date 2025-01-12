<?php

namespace App\Jobs;

use App\Contracts\DnsProvider;
use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateStackDnsRecords implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The project instance.
     *
     * @var \App\Models\Project
     */
    public $project;

    /**
     * The IP address of the balancer that was deleted.
     *
     * Only update stacks that have this DNS entrypoint.
     *
     * @var string
     */
    public $ipAddress;

    /**
     * Create a new job instance.
     *
     * @param  \App\Models\Project $project
     * @param  string|null         $ipAddress
     *
     * @return void
     */
    public function __construct(Project $project, $ipAddress = null)
    {
        $this->project = $project;
        $this->ipAddress = $ipAddress;
    }

    /**
     * Execute the job.
     *
     * @param  \App\Contracts\DnsProvider  $dns
     * @return void
     */
    public function handle(DnsProvider $dns)
    {
        $this->project->allStacks()->filter(function ($stack) {
            return $stack->dns_address == $this->ipAddress;
        })->each(function ($stack) use ($dns) {
            $dns->addRecord($stack);
        });
    }
}
