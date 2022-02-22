<?php

namespace App\Jobs;

use App\Callbacks\CheckActivation;
use App\Callbacks\StartBackgroundServices;
use App\Models\ServerDeployment;
use App\Scripts\Activate as ActivateScript;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Activate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The server deployment instance.
     *
     * @var \App\Models\ServerDeployment
     */
    public $deployment;

    /**
     * Create a new job instance.
     *
     * @param  \App\Models\ServerDeployment $deployment
     *
     * @return void
     */
    public function __construct(ServerDeployment $deployment)
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
        $this->deployment->update([
            'activation_task_id' => $this->activate()->id,
        ]);
    }

    /**
     * Run the activation script on the server.
     *
     * @return \App\Models\Task
     */
    protected function activate()
    {
        $deployable = $this->deployment->deployable;

        return $deployable->runInBackground(new ActivateScript($this->deployment), [
            'then' => [
                new CheckActivation($this->deployment->id),
                new StartBackgroundServices($this->deployment->id),
            ],
        ]);
    }

    /**
     * Handle a job failure.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        $this->deployment->project()->alerts()->create([
            'stack_id' => $this->deployment->stack()->id,
            'type' => 'ActivationFailed',
            'exception' => (string) $exception,
            'meta' => [],
        ]);
    }
}
