<?php

namespace App\Jobs;

use App\Models\StackTask;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RunStackTask implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The stack task.
     *
     * @var \App\Models\StackTask
     */
    public $task;

    /**
     * Create a new job instance.
     *
     * @param  \App\Models\StackTask $task
     *
     * @return void
     */
    public function __construct(StackTask $task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->task->run();
    }
}
