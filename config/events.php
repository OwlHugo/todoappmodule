<?php

return [
    'listeners' => [
        \App\Modules\Task\Events\TaskCreated::class => [
            \App\Modules\Task\Listeners\SendTaskNotification::class,
            \App\Modules\Task\Listeners\LogTaskActivity::class . '@handleTaskCreated',
        ],
        \App\Modules\Task\Events\TaskUpdated::class => [
            \App\Modules\Task\Listeners\LogTaskActivity::class . '@handleTaskUpdated',
        ],
        \App\Modules\Task\Events\TaskDeleted::class => [
            \App\Modules\Task\Listeners\LogTaskActivity::class . '@handleTaskDeleted',
        ],
        \App\Modules\Task\Events\TaskCompleted::class => [
            \App\Modules\Task\Listeners\LogTaskActivity::class . '@handleTaskCompleted',
        ],
    ],
]; 