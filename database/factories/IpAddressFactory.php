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

$factory->define(\App\Models\IpAddress::class, function () {
    return [
        'addressable_id' => factory(\App\Models\Database::class),
        'addressable_type' => \App\Models\Database::class,
        'public_address' => '127.0.0.1',
        'private_address' => '127.0.0.2',
    ];
});
