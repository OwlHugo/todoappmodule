<?php

namespace App\Modules\Task\Repositories;

use App\Bootstrap\Repositories\BaseRepository;
use App\Modules\Task\DTOs\TaskData;
use App\Modules\Task\Models\Task;
use App\Modules\Task\Enums\TaskStatus;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository extends BaseRepository
{
    public function __construct(Task $task)
    {
        parent::__construct($task);
    }
    public function createTask(TaskData $taskData): Task
    {
        return Task::create($taskData->toArray());
    }

    public function updateTask(Task $task, TaskData $taskData): Task
    {
        $task->update($taskData->toArray());
        return $task->fresh();
    }

    public function deleteTask(Task $task): bool
    {
        return $task->delete();
    }

    public function findById(int $id): ?Task
    {
        return Task::find($id);
    }

    public function findByIdForUser(int $id, User $user): ?Task
    {
        return Task::forUser($user)->find($id);
    }

    public function getForUser(User $user, ?TaskStatus $status = null, ?string $dueDate = null): Collection
    {
        return Task::forUser($user)
            ->byStatus($status)
            ->byDueDate($dueDate)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getOverdueForUser(User $user): Collection
    {
        return Task::forUser($user)
            ->where('status', TaskStatus::Open)
            ->where('due_date', '<', now())
            ->orderBy('due_date', 'asc')
            ->get();
    }

    public function getCompletedForUser(User $user): Collection
    {
        return Task::forUser($user)
            ->where('status', TaskStatus::Done)
            ->orderBy('updated_at', 'desc')
            ->get();
    }
} 