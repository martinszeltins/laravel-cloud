<?php

namespace Tests\Feature;

use App\Jobs\SyncNetwork;
use App\Models\Database;
use App\Models\Stack;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class StackDatabaseControllerTest extends TestCase
{
    use RefreshDatabase;


    public function setUp()
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }


    public function test_database_can_be_added_to_stack()
    {
        Bus::fake();

        $stack = factory(Stack::class)->create([
            'status' => 'provisioned',
        ]);

        $database = factory(Database::class)->create([
            'project_id' => $stack->project()->id,
        ]);

        $response = $this->actingAs(
            $stack->environment->project->user, 'api'
        )->json('put', '/api/stack/'.$stack->id.'/databases', [
            'databases' => [$database->name],
        ]);

        $response->assertStatus(200);

        $stack = $stack->fresh();
        $this->assertTrue($stack->databases->contains($database));

        Bus::assertDispatched(SyncNetwork::class);
    }


    public function test_database_can_be_removed_from_stack()
    {
        Bus::fake();

        $stack = factory(Stack::class)->create([
            'status' => 'provisioned',
        ]);

        $database = factory(Database::class)->create([
            'project_id' => $stack->project()->id,
        ]);

        $stack->databases()->attach($database);

        $response = $this->actingAs(
            $stack->environment->project->user, 'api'
        )->json('put', '/api/stack/'.$stack->id.'/databases', [
            'databases' => [],
        ]);

        $response->assertStatus(200);

        $stack = $stack->fresh();
        $this->assertFalse($stack->databases->contains($database));

        Bus::assertDispatched(SyncNetwork::class);
    }


    public function test_nothing_happens_if_no_databases_are_affected()
    {
        Bus::fake();

        $stack = factory(Stack::class)->create([
            'status' => 'provisioned',
        ]);

        $database = factory(Database::class)->create([
            'project_id' => $stack->project()->id,
        ]);

        $stack->databases()->attach($database);

        $response = $this->actingAs(
            $stack->environment->project->user, 'api'
        )->json('put', '/api/stack/'.$stack->id.'/databases', [
            'databases' => [$database->name],
        ]);

        $response->assertStatus(200);

        $stack = $stack->fresh();
        $this->assertTrue($stack->databases->contains($database));

        Bus::assertNotDispatched(SyncNetwork::class);
    }
}
