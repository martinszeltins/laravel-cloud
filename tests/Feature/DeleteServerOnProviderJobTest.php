<?php

namespace Tests\Feature;

use App\Jobs\DeleteServerOnProvider;
use App\Models\Project;
use Facades\App\ServerProviderClientFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteServerOnProviderJobTest extends TestCase
{
    use RefreshDatabase;


    public function setUp()
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }


    public function test_server_is_deleted_using_provider()
    {
        $project = factory(Project::class)->create();

        $job = new DeleteServerOnProvider($project, '123');

        ServerProviderClientFactory::shouldReceive('make->deleteServerById')
                        ->with('123');

        $job->handle();

        $this->assertTrue(true);
    }
}
