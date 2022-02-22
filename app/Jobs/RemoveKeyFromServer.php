<?php

namespace App\Jobs;

use App\Contracts\Provisionable;
use App\Models\User;
use App\Scripts\RemoveKeyFromServer as RemoveKeyFromServerScript;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RemoveKeyFromServer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The user instance.
     *
     * @var \App\Models\User
     */
    public $user;

    /**
     * The provisionable implementation.
     *
     * @var \App\Contracts\Provisionable
     */
    public $provisionable;

    /**
     * Delete this job if any injected models are missing.
     *
     * @var bool
     */
    protected $deleteWhenMissingModels = true;

    /**
     * Create a new job instance.
     *
     * @param  \App\Models\User             $user
     * @param  \App\Contracts\Provisionable $provisionable
     *
     * @return void
     */
    public function __construct(User $user, Provisionable $provisionable)
    {
        $this->user = $user;
        $this->provisionable = $provisionable;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->provisionable->run(new RemoveKeyFromServerScript(
            'cloud-user-'.$this->user->id
        ));
    }
}
