<?php

namespace App\Jobs;

use App\Mail\StackProvisioned;
use App\Models\Stack;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class MarkStackAsProvisioned implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        $this->stack->markAsProvisioned();

        Mail::to($this->stack->environment->project->user)->send(
            new StackProvisioned($this->stack)
        );
    }
}
