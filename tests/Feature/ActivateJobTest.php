<?php

namespace Tests\Feature;

use App\Callbacks\CheckActivation;
use App\Callbacks\StartBackgroundServices;
use App\Jobs\Activate;
use App\Models\ServerDeployment;
use App\Scripts\Activate as ActivateScript;
use App\Scripts\Script;
use App\Services\AppServer;
use App\Services\Shell\ShellProcessRunner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivateJobTest extends TestCase
{
    use RefreshDatabase;


    public function setUp()
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }


    public function test_task_id_is_stored()
    {
        $serverDeployment = factory(ServerDeployment::class)->create();
        $serverDeployment->setRelation('deployable', $deployable = new ActivateJobTestFakeDeployable);
        $serverDeployment->stack()->environment->update([
            'name' => 'workbench',
        ]);

        $job = new Activate($serverDeployment);

        ShellProcessRunner::mock([
            (object) ['exitCode' => 0, 'output' => '', 'timedOut' => false],
        ]);

        $job->handle();

        $this->assertEquals(123, $serverDeployment->fresh()->activation_task_id);
        $this->assertInstanceOf(ActivateScript::class, $deployable->script);
        $this->assertInstanceOf(CheckActivation::class, $deployable->options['then'][0]);
        $this->assertInstanceOf(StartBackgroundServices::class, $deployable->options['then'][1]);
    }
}


class ActivateJobTestFakeDeployable extends AppServer
{
    public $script;
    public $options;

    public function runInBackground(Script $script, array $options = [])
    {
        $this->script = $script;
        $this->options = $options;

        return (object) ['id' => 123];
    }
}
