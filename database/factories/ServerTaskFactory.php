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

$factory->define(\App\Models\ServerTask::class, function () {
    return [
        'stack_task_id' => factory(\App\Models\StackTask::class),
        'taskable_id' => factory(\App\Models\WebServer::class),
        'taskable_type' => 'App\Models\WebServer',
        'task_id' => factory(\App\Models\Task::class),
        'commands' => [
            'exit 1',
        ],
    ];
});
