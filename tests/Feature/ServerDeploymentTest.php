<?php

namespace Tests\Feature;

use App\Models\Database;
use App\Models\IpAddress;
use App\Models\ServerDeployment;
use App\Services\AppServer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServerDeploymentTest extends TestCase
{
    use RefreshDatabase;


    public function test_database_methods_return_first_database_if_only_one()
    {
        $deployment = factory(ServerDeployment::class)->create();
        $deployment->stack()->databases()->save($database = factory(Database::class)->make());
        $database->address()->save(factory(IpAddress::class)->make());

        $this->assertEquals($database->address->private_address, $deployment->databaseHost());
        $this->assertEquals($database->password, $deployment->databasePassword());
    }


    public function test_app_server_information_is_used_if_no_other_databases_are_present()
    {
        $deployment = factory(ServerDeployment::class)->create();
        $deployment->setRelation('deployable', $server = factory(AppServer::class)->make());

        $this->assertEquals('127.0.0.1', $deployment->databaseHost());
        $this->assertEquals($server->database_password, $deployment->databasePassword());
    }
}
