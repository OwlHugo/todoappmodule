<?php

namespace Database\Factories;

use App\Modules\Task\Models\Task;
use App\Modules\Task\Enums\TaskStatus;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Modules\Task\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(2),
            'status' => fake()->randomElement([TaskStatus::Open, TaskStatus::Done]),
            'due_date' => fake()->optional()->dateTimeBetween('now', '+30 days'),
            'user_id' => User::factory(),
        ];
    }
}
