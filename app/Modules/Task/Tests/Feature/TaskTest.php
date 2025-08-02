<?php

namespace App\Modules\Task\Tests\Feature;

use App\Modules\Task\Models\Task;
use App\Modules\Task\Enums\TaskStatus;
use App\Modules\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_tasks_index(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('tasks.index'));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Tasks/Index'));
    }

    public function test_user_can_view_create_task_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('tasks.create'));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Tasks/Create'));
    }

    public function test_user_can_create_task(): void
    {
        $user = User::factory()->create();

        $taskData = [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'status' => TaskStatus::Open->value,
            'due_date' => now()->addDays(7)->format('Y-m-d'),
        ];

        $response = $this->actingAs($user)->post(route('tasks.store'), $taskData);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'user_id' => $user->id,
        ]);
    }

    public function test_user_can_view_edit_task_page(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('tasks.edit', $task));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Tasks/Edit'));
    }

    public function test_user_can_update_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $updateData = [
            'title' => 'Updated Task',
            'description' => 'Updated Description',
            'status' => TaskStatus::Done->value,
            'due_date' => now()->addDays(14)->format('Y-m-d'),
        ];

        $response = $this->actingAs($user)->put(route('tasks.update', $task), $updateData);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated Task',
            'description' => 'Updated Description',
        ]);
    }

    public function test_user_can_delete_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));
        $this->assertSoftDeleted('tasks', ['id' => $task->id]);
    }

    public function test_user_cannot_access_other_user_task(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user2->id]);

        $response = $this->actingAs($user1)->get(route('tasks.edit', $task));

        $response->assertStatus(404);
    }

    public function test_user_cannot_update_other_user_task(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user2->id]);

        $updateData = [
            'title' => 'Updated Task',
            'description' => 'Updated Description',
            'status' => TaskStatus::Done->value,
        ];

        $response = $this->actingAs($user1)->put(route('tasks.update', $task), $updateData);

        $response->assertStatus(404);
    }

    public function test_user_cannot_delete_other_user_task(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user2->id]);

        $response = $this->actingAs($user1)->delete(route('tasks.destroy', $task));

        $response->assertStatus(404);
    }

    public function test_task_validation_requires_title(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('tasks.store'), [
            'description' => 'Test Description',
            'status' => TaskStatus::Open->value,
        ]);

        $response->assertSessionHasErrors(['title']);
    }

    public function test_task_validation_requires_description(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('tasks.store'), [
            'title' => 'Test Task',
            'status' => TaskStatus::Open->value,
        ]);

        $response->assertSessionHasErrors(['description']);
    }

    public function test_task_validation_requires_status(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('tasks.store'), [
            'title' => 'Test Task',
            'description' => 'Test Description',
        ]);

        $response->assertSessionHasErrors(['status']);
    }

    public function test_can_filter_tasks_by_status(): void
    {
        $user = User::factory()->create();
        Task::factory()->create(['user_id' => $user->id, 'status' => TaskStatus::Open]);
        Task::factory()->create(['user_id' => $user->id, 'status' => TaskStatus::Done]);

        $response = $this->actingAs($user)->get(route('tasks.index', ['status' => 'open']));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('Tasks/Index') &&
            $page->has('tasks') &&
            count($page->toArray()['props']['tasks']) === 1
        );
    }

    public function test_can_filter_tasks_by_due_date(): void
    {
        $user = User::factory()->create();
        $dueDate = now()->addDays(7)->format('Y-m-d');
        
        Task::factory()->create([
            'user_id' => $user->id, 
            'due_date' => $dueDate
        ]);
        Task::factory()->create([
            'user_id' => $user->id, 
            'due_date' => now()->addDays(14)->format('Y-m-d')
        ]);

        $response = $this->actingAs($user)->get(route('tasks.index', ['due_date' => $dueDate]));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => 
            $page->component('Tasks/Index') &&
            $page->has('tasks') &&
            count($page->toArray()['props']['tasks']) === 1
        );
    }
}
