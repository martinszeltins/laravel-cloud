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

$factory->define(\App\Models\Database::class, function () {
    return [
        'project_id' => factory(\App\Models\Project::class),
        'name' => str_random(6),
        'size' => '2gb',
        'provider_server_id' => 1,
        'port' => 22,
        'sudo_password' => str_random(40),
        'username' => str_random(40),
        'password' => str_random(40),
        'allows_access_from' => [],
        'status' => 'provisioned',
    ];
});
