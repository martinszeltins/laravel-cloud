<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(\App\Models\DatabaseRestore::class, function () {
    return [
        'database_id' => factory(\App\Models\Database::class),
        'database_backup_id' => factory(\App\Models\DatabaseBackup::class),
        'database_name' => 'Test Database',
        'status' => 'running',
        'output' => '',
    ];
});
