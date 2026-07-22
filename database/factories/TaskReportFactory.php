<?php

namespace Database\Factories;

use App\Enums\TaskReportStatus;
use App\Models\Task;
use App\Models\TaskReport;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<TaskReport>
 */
class TaskReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'task_id' => Task::factory(),
            'user_id' => User::factory(),
            'started_photo' => 'task-reports/start/'.fake()->uuid().'.jpg',
            'finished_photo' => null,
            'started_at' => now(),
            'finished_at' => null,
            'duration_minutes' => null,
            'status' => TaskReportStatus::InProgress,
        ];
    }
}
