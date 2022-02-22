<?php

namespace App\Jobs;

use App\Callbacks\CheckBuild;
use App\Models\ServerDeployment;
use App\Scripts\Build as BuildScript;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Build implements ShouldQueue
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
            'build_task_id' => $this->build()->id,
        ]);
    }

    /**
     * Run the build script on the server.
     *
     * @return \App\Models\Task
     */
    protected function build()
    {
        $deployable = $this->deployment->deployable;

        return $deployable->runInBackground(new BuildScript($this->deployment), [
            'then' => [
                new CheckBuild($this->deployment->id),
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
        $this->deployment->deployment->project()->alerts()->create([
            'stack_id' => $this->deployment->stack()->id,
            'type' => 'BuildFailed',
            'exception' => (string) $exception,
            'meta' => [],
        ]);
    }
}
