<?php

namespace Tests\Feature;

use App\Callbacks\StartBackgroundServices;
use App\Jobs\RestartDaemons;
use App\Jobs\StartScheduler;
use App\Models\ServerDeployment;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class StartBackgroundServicesCallbackTest extends TestCase
{
    use RefreshDatabase;


    public function setUp()
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }


    public function test_background_services_are_started_if_applicable()
    {
        Bus::fake();

        $deployment = factory(ServerDeployment::class)->create();

        $deployment->stack()->environment->update([
            'name' => 'workbench',
        ]);

        $deployment->deployment->update([
            'stack_id' => $deployment->stack()->id,
            'daemons' => ['first'],
            'schedule' => ['first'],
        ]);

        $callback = new StartBackgroundServices($deployment->id);
        $callback->handle(factory(Task::class)->create());

        $this->assertTrue($deployment->deployable->fresh()->daemonsAreRunning());

        Bus::assertDispatched(StartScheduler::class, function ($job) use ($deployment) {
            return $job->deployment->id === $deployment->id;
        });

        Bus::assertDispatched(RestartDaemons::class, function ($job) use ($deployment) {
            return $job->deployment->id === $deployment->id;
        });
    }



    public function test_background_services_are_not_started_if_in_production_and_are_not_already_running()
    {
        Bus::fake();

        $deployment = factory(ServerDeployment::class)->create();
        $deployment->deployment->update([
            'stack_id' => $deployment->stack()->id,
            'daemons' => ['first'],
            'schedule' => ['first'],
        ]);

        $callback = new StartBackgroundServices($deployment->id);
        $callback->handle(factory(Task::class)->create());

        $this->assertFalse($deployment->deployable->fresh()->daemonsAreRunning());

        Bus::assertNotDispatched(StartScheduler::class);
        Bus::assertNotDispatched(RestartDaemons::class);
    }


    public function test_background_services_are_started_if_in_production_and_are_already_running()
    {
        Bus::fake();

        $deployment = factory(ServerDeployment::class)->create();

        $deployment->deployable->update([
            'daemon_status' => 'running',
        ]);

        $deployment->deployment->update([
            'stack_id' => $deployment->stack()->id,
            'daemons' => ['first'],
            'schedule' => ['first'],
        ]);

        $callback = new StartBackgroundServices($deployment->id);
        $callback->handle(factory(Task::class)->create());

        $this->assertTrue($deployment->deployable->fresh()->daemonsAreRunning());

        Bus::assertDispatched(StartScheduler::class);
        Bus::assertDispatched(RestartDaemons::class);
    }
}
