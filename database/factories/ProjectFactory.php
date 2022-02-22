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

$factory->define(\App\Models\Project::class, function () {
    return [
        'user_id' => factory(\App\Models\User::class),
        'server_provider_id' => factory(\App\Models\ServerProvider::class),
        'source_provider_id' => factory(\App\Models\SourceProvider::class),
        'repository' => 'taylorotwell/hello-world',
        'name' => 'Laravel',
        'region' => 'nyc3',
    ];
});
