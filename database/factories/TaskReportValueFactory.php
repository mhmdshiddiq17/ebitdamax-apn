<?php

namespace Database\Factories;

use App\Models\TaskAdditionalField;
use App\Models\TaskReport;
use App\Models\TaskReportValue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TaskReportValue>
 */
class TaskReportValueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'task_report_id' => TaskReport::factory(),
            'task_additional_field_id' => TaskAdditionalField::factory(),
            'value' => fake()->sentence(),
        ];
    }
}
