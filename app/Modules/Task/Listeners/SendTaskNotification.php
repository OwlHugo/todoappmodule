<?php

namespace App\Modules\Task\Listeners;

use App\Modules\Task\Events\TaskCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTaskNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(TaskCreated $event): void
    {
        $task = $event->task;
        
        logger()->info("Nova tarefa criada: {$task->title} por {$task->user->name}");
    }
} 