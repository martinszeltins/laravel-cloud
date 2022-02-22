<?php

namespace Tests\Feature;

use App\Models\ServerDeployment;
use App\Scripts\Activate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivateScriptTest extends TestCase
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

        $script = new Activate($deployment);

        $this->assertNotNull($script->script());
    }
}
