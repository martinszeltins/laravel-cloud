<?php

namespace Tests\Feature;

use App\Models\DatabaseBackup;
use App\Models\DatabaseRestore;
use App\Scripts\RestoreDatabaseBackup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RestoreDatabaseBackupScriptTest extends TestCase
{
    use RefreshDatabase;


    public function setUp()
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }


    public function test_script_can_be_rendered()
    {
        $backup = factory(DatabaseBackup::class)->create();

        $backup->restores()->save($restore = factory(DatabaseRestore::class)->make());

        $script = new RestoreDatabaseBackup($restore);

        $this->assertNotNull($script->script());
    }
}
