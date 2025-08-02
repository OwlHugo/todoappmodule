<?php

namespace App\Modules\Task\Http\Controllers;

use App\Bootstrap\Controllers\Controller;
use App\Modules\Task\Models\Task;
use App\Modules\Task\Repositories\TaskRepository;
use App\Modules\Task\Services\TaskService;
use App\Modules\Task\Http\Requests\StoreTaskRequest;
use App\Modules\Task\Http\Requests\UpdateTaskRequest;
use App\Modules\Task\Http\Resources\TaskResource;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    public function __construct(
        private TaskService $taskService,
        private TaskRepository $taskRepository,
    ) {}

    public function index(Request $request): Response
    {
        $status = $request->get('status');
        $dueDate = $request->get('due_date');

        $tasks = $this->taskService->getTasks(
            user: auth()->user(),
            status: $status,
            dueDate: $dueDate,
        );

        return Inertia::render('Tasks/Index', [
            'tasks' => TaskResource::collection($tasks),
            'filters' => [
                'status' => $status,
                'due_date' => $dueDate,
            ],
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Tasks/Create');
    }

    public function store(StoreTaskRequest $request)
    {
        $task = $this->taskService->createTask($request->validated(), auth()->user());

        return redirect()->route('tasks.index')
            ->with('success', 'Tarefa criada com sucesso!');
    }

    public function edit(Task $task): Response
    {
        $task = $this->taskRepository->findByIdForUser($task->id, auth()->user());
        
        if (!$task) {
            abort(404);
        }

        $taskResource = new TaskResource($task);

        return Inertia::render('Tasks/Edit', [
            'task' => $taskResource,
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task = $this->taskRepository->findByIdForUser($task->id, auth()->user());
        
        if (!$task) {
            abort(404);
        }

        $this->taskService->updateTask($task, $request->validated());

        return redirect()->route('tasks.index')
            ->with('success', 'Tarefa atualizada com sucesso!');
    }

    public function destroy(Task $task)
    {
        $task = $this->taskRepository->findByIdForUser($task->id, auth()->user());
        
        if (!$task) {
            abort(404);
        }

        $this->taskService->deleteTask($task);

        return redirect()->route('tasks.index')
            ->with('success', 'Tarefa excluída com sucesso!');
    }

    public function testFilter(Request $request)
    {
        $status = $request->get('status');
        $dueDate = $request->get('due_date');
        
        $tasks = $this->taskService->getTasks(
            user: auth()->user(),
            status: $status,
            dueDate: $dueDate,
        );

        return response()->json([
            'filters' => [
                'status' => $status,
                'due_date' => $dueDate,
            ],
            'count' => $tasks->count(),
            'tasks' => TaskResource::collection($tasks),
        ]);
    }
} 