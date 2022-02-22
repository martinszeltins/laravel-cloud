<?php

namespace Tests\Feature;

use App\Models\ServerDeployment;
use App\Scripts\Build;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BuildScriptTest extends TestCase
{
    use RefreshDatabase;


    public function setUp()
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }


    public function test_script_can_be_rendered()
    {
        $deployment = factory(ServerDeployment::class)->create();

        $deployment->deployable->createDaemonGeneration();

        $script = new Build($deployment);

        $this->assertNotNull($script->script());
    }
}
