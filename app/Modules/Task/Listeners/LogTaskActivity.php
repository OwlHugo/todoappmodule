<?php

namespace App\Modules\Task\Listeners;

use App\Modules\Task\Events\TaskCreated;
use App\Modules\Task\Events\TaskUpdated;
use App\Modules\Task\Events\TaskDeleted;
use App\Modules\Task\Events\TaskCompleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogTaskActivity implements ShouldQueue
{
    use InteractsWithQueue;

    public function handleTaskCreated(TaskCreated $event): void
    {
        $task = $event->task;
        logger()->info("Tarefa criada: {$task->title} (ID: {$task->id})");
    }

    public function handleTaskUpdated(TaskUpdated $event): void
    {
        $task = $event->task;
        logger()->info("Tarefa atualizada: {$task->title} (ID: {$task->id})");
    }

    public function handleTaskDeleted(TaskDeleted $event): void
    {
        $task = $event->task;
        logger()->info("Tarefa excluída: {$task->title} (ID: {$task->id})");
    }

    public function handleTaskCompleted(TaskCompleted $event): void
    {
        $task = $event->task;
        logger()->info("Tarefa concluída: {$task->title} (ID: {$task->id})");
    }
} 