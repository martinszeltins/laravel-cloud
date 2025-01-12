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

$factory->define(\App\Models\Task::class, function () {
    return [
        'project_id' => factory(\App\Models\Project::class),
        'provisionable_id' => factory(\App\Models\Database::class),
        'provisionable_type' => 'App\Models\Database',
        'name' => 'Task Name',
        'user' => 'root',
        'status' => 'finished',
        'exit_code' => 0,
        'script' => '',
        'output' => '',
        'options' => [],
    ];
});
