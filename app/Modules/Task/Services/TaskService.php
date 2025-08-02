<?php

namespace App\Modules\Task\Services;

use App\Modules\Task\Enums\TaskStatus;
use App\Modules\Task\Events\TaskCreated;
use App\Modules\Task\Events\TaskDeleted;
use App\Modules\Task\Events\TaskUpdated;
use App\Modules\Task\Models\Task;
use App\Modules\User\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    public function createTask(array $data, User $user): Task
    {
        $dueDate = null;
        if (isset($data['due_date']) && !empty(trim($data['due_date']))) {
            try {
                $dueDate = Carbon::parse($data['due_date'])->format('Y-m-d H:i:s');
            } catch (\Exception $e) {
                $dueDate = null;
            }
        }

        $task = Task::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'] ?? 'open',
            'due_date' => $dueDate,
            'user_id' => $user->id,
        ]);

        TaskCreated::dispatch($task);

        return $task;
    }

    public function updateTask(Task $task, array $data): Task
    {
        $dueDate = $task->due_date;
        if (isset($data['due_date'])) {
            if (!empty(trim($data['due_date']))) {
                try {
                    $dueDate = Carbon::parse($data['due_date'])->format('Y-m-d H:i:s');
                } catch (\Exception $e) {
                    $dueDate = null;
                }
            } else {
                $dueDate = null;
            }
        }

        $task->update([
            'title' => $data['title'] ?? $task->title,
            'description' => $data['description'] ?? $task->description,
            'status' => $data['status'] ?? $task->status,
            'due_date' => $dueDate,
        ]);

        TaskUpdated::dispatch($task);

        return $task;
    }

    public function deleteTask(Task $task): bool
    {
        TaskDeleted::dispatch($task);

        return $task->delete();
    }

    public function getTasks(User $user, ?string $status = null, ?string $dueDate = null): Collection
    {
        $query = Task::query()
            ->forUser($user)
            ->with('user');

        if ($status && !empty(trim($status))) {
            $taskStatus = TaskStatus::tryFrom($status);
            $query->byStatus($taskStatus);
        }

        if ($dueDate && !empty(trim($dueDate))) {
            \Log::info('Filtrando por data:', ['due_date' => $dueDate]);
            $query->byDueDate($dueDate);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function findTaskById(int $id, User $user): ?Task
    {
        return $this->getTasks($user)->firstWhere('id', $id);
    }

    public function getTasksByDueDate(User $user, string $dueDate): Collection
    {
        $query = Task::query()
            ->forUser($user)
            ->with('user');
        
        $query->byDueDate($dueDate);
        
        return $query->orderBy('created_at', 'desc')->get();
    }

    public function testDueDateFilter(User $user, string $dueDate): array
    {
        $formats = [
            'Y-m-d' => date('Y-m-d', strtotime($dueDate)),
            'd/m/Y' => date('d/m/Y', strtotime($dueDate)),
            'Y-m-d H:i:s' => date('Y-m-d H:i:s', strtotime($dueDate)),
        ];

        $results = [];
        
        foreach ($formats as $format => $formattedDate) {
            $query = Task::query()->forUser($user);
            $query->byDueDate($formattedDate);
            $results[$format] = $query->count();
        }

        return $results;
    }
} 