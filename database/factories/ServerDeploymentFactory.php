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

$factory->define(\App\Models\ServerDeployment::class, function () {
    return [
        'deployment_id' => factory(\App\Models\Deployment::class),
        'deployable_id' => factory(\App\Services\AppServer::class),
        'deployable_type' => \App\Services\AppServer::class,
        'build_commands' => [],
        'activation_commands' => [],
        'status' => 'running',
    ];
});
