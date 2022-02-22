<?php

namespace Tests\Feature;

use App\Models\DatabaseBackup;
use App\Scripts\StoreDatabaseBackup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreDatabaseBackupScriptTest extends TestCase
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

        $script = new StoreDatabaseBackup($backup);

        $this->assertNotNull($script->script());
    }
}
