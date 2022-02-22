<?php

namespace Tests\Feature;

use App\Jobs\RestartDaemons;
use App\Models\Deployment;
use App\Models\ServerDeployment;
use App\Services\Shell\ShellProcessRunner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RestartDaemonsJobTest extends TestCase
{
    use RefreshDatabase;


    public function setUp()
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }


    public function test_daemons_are_restarted()
    {
        $deployment = factory(Deployment::class)->create([
            'daemons' => [
                'first' => [
                    'command' => 'php artisan horizon',
                ],
            ],
        ]);

        $deployment->serverDeployments()->save(
            $serverDeployment = factory(ServerDeployment::class)->make()
        );

        ShellProcessRunner::mock([
            (object) ['exitCode' => 0, 'output' => '', 'timedOut' => false],
        ]);

        $job = new RestartDaemons($serverDeployment);
        $job->handle();

        $this->assertCount(1, $serverDeployment->deployable->fresh()->daemonGenerations);
    }
}
