<?php

namespace App\Http\Controllers;

use App\Enums\TaskAdditionalFieldShowWhen;
use App\Enums\TaskReportStatus;
use App\Http\Requests\FinishTaskRequest;
use App\Http\Requests\StartTaskRequest;
use App\Models\Task;
use App\Models\TaskAdditionalField;
use App\Models\TaskReport;
use App\Models\TaskReportValue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TaskReportController extends Controller
{
    public function start(StartTaskRequest $request, Task $task): RedirectResponse
    {
        abort_unless($request->user()?->role_id === $task->role_id, 403);

        DB::transaction(function () use ($request, $task): void {
            $report = TaskReport::query()
                ->where('task_id', $task->id)
                ->where('user_id', $request->user()->id)
                ->where('status', TaskReportStatus::InProgress->value)
                ->first();

            if (! $report) {
                $report = TaskReport::query()->create([
                    'task_id' => $task->id,
                    'user_id' => $request->user()->id,
                    'started_at' => now(),
                    'status' => TaskReportStatus::InProgress,
                ]);
            }

            $report->update([
                'started_photo' => $request->file('started_photo')->store('task-reports/start', config('filesystems.default')),
                'started_at' => $report->started_at ?? now(),
                'status' => TaskReportStatus::InProgress,
            ]);

            $this->syncValues(
                report: $report,
                task: $task,
                values: $request->validated('values', []),
                showWhen: TaskAdditionalFieldShowWhen::Start
            );
        });

        return back()->with('success', 'Task berhasil dimulai.');
    }

    public function finish(FinishTaskRequest $request, Task $task): RedirectResponse
    {
        abort_unless($request->user()?->role_id === $task->role_id, 403);

        DB::transaction(function () use ($request, $task): void {
            $report = TaskReport::query()
                ->where('task_id', $task->id)
                ->where('user_id', $request->user()->id)
                ->where('status', TaskReportStatus::InProgress->value)
                ->latest('started_at')
                ->firstOrFail();

            $finishedAt = now();

            $report->update([
                'finished_photo' => $request->file('finished_photo')->store('task-reports/finish', config('filesystems.default')),
                'finished_at' => $finishedAt,
                'duration_minutes' => $report->started_at
                    ? max(0, (int) floor($report->started_at->diffInSeconds($finishedAt) / 60))
                    : null,
                'status' => TaskReportStatus::Completed,
            ]);

            $this->syncValues(
                report: $report,
                task: $task,
                values: $request->validated('values', []),
                showWhen: TaskAdditionalFieldShowWhen::Finish
            );
        });

        return back()->with('success', 'Task berhasil diselesaikan.');
    }

    /**
     * @param  array<string, mixed>  $values
     */
    private function syncValues(
        TaskReport $report,
        Task $task,
        array $values,
        TaskAdditionalFieldShowWhen $showWhen
    ): void {
        $fields = TaskAdditionalField::query()
            ->where('task_id', $task->id)
            ->where('show_when', $showWhen->value)
            ->get();

        foreach ($fields as $field) {
            $value = $values[$field->field_name] ?? null;

            if ($field->is_required && $this->isEmptyValue($value)) {
                throw ValidationException::withMessages([
                    "values.{$field->field_name}" => "{$field->label} wajib diisi.",
                ]);
            }

            TaskReportValue::query()->updateOrCreate(
                [
                    'task_report_id' => $report->id,
                    'task_additional_field_id' => $field->id,
                ],
                [
                    'value' => is_array($value) ? json_encode($value) : $value,
                ]
            );
        }
    }

    private function isEmptyValue(mixed $value): bool
    {
        if (is_array($value)) {
            return Arr::where($value, fn (mixed $item): bool => ! $this->isEmptyValue($item)) === [];
        }

        return $value === null || $value === '';
    }
}
