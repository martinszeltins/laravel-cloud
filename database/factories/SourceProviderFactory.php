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


$factory->define(\App\Models\SourceProvider::class, function () {
    return [
        'user_id' => factory(\App\Models\User::class),
        'name' => 'GitHub',
        'type' => 'GitHub',
        'meta' => ['token' => config('services.testing.github')],
    ];
});
