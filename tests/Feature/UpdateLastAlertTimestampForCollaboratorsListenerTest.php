<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateLastAlertTimestampForCollaboratorsListenerTest extends TestCase
{
    use RefreshDatabase;


    public function setUp()
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }


    public function test_last_alert_received_at_timestamps_are_updated()
    {
        $project = factory(Project::class)->create();
        $project->shareWith($collaborator = factory(User::class)->create());

        $this->assertNull($project->user->fresh()->last_alert_received_at);
        $this->assertNull($collaborator->fresh()->last_alert_received_at);

        $alert = $project->alerts()->create([
            'type' => 'Something',
            'exception' => 'exception',
            'meta' => [],
        ]);

        $this->assertNotNull($project->user->fresh()->last_alert_received_at);
        $this->assertNotNull($collaborator->fresh()->last_alert_received_at);
    }
}
