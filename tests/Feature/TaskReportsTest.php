<?php

use App\Enums\RoleLevel;
use App\Enums\TaskReportStatus;
use App\Models\Role;
use App\Models\Task;
use App\Models\TaskAdditionalField;
use App\Models\TaskCategory;
use App\Models\TaskReport;
use App\Models\TaskReportValue;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('staff can start task for their role', function () {
    Storage::fake('local');

    $category = TaskCategory::factory()->create();
    $role = Role::factory()->create(['level' => RoleLevel::Staff]);
    $user = User::factory()->create(['role_id' => $role->id]);
    $task = Task::factory()->create([
        'task_category_id' => $category->id,
    ]);
    $task->roles()->sync([$role->id]);
    $field = TaskAdditionalField::factory()->create([
        'task_id' => $task->id,
        'label' => 'Nama Pelanggan',
        'field_name' => 'nama_pelanggan',
        'show_when' => 'start',
        'is_required' => true,
    ]);

    $this->actingAs($user)
        ->post(route('tasks.start', $task), [
            'started_photo' => UploadedFile::fake()->image('mulai.jpg'),
            'values' => [
                'nama_pelanggan' => 'Budi',
            ],
        ])
        ->assertRedirect()
        ->assertSessionHasNoErrors();

    $report = TaskReport::query()->firstOrFail();

    expect($report->task_id)->toBe($task->id)
        ->and($report->user_id)->toBe($user->id)
        ->and($report->period_key)->toBe('once')
        ->and($report->status)->toBe(TaskReportStatus::InProgress)
        ->and($report->started_at)->not->toBeNull()
        ->and($report->started_photo)->not->toBeNull();

    Storage::disk('local')->assertExists($report->started_photo);

    expect(TaskReportValue::query()
        ->where('task_report_id', $report->id)
        ->where('task_additional_field_id', $field->id)
        ->value('value'))->toBe('Budi');
});

test('staff can finish in progress task for their role', function () {
    Storage::fake('local');

    $category = TaskCategory::factory()->create();
    $role = Role::factory()->create(['level' => RoleLevel::Staff]);
    $user = User::factory()->create(['role_id' => $role->id]);
    $task = Task::factory()->create([
        'task_category_id' => $category->id,
    ]);
    $task->roles()->sync([$role->id]);
    $field = TaskAdditionalField::factory()->create([
        'task_id' => $task->id,
        'label' => 'Uang Masuk',
        'field_name' => 'uang_masuk',
        'show_when' => 'finish',
        'is_required' => true,
    ]);
    $report = TaskReport::query()->create([
        'task_id' => $task->id,
        'user_id' => $user->id,
        'period_key' => 'once',
        'started_photo' => 'task-reports/start/example.jpg',
        'started_at' => now()->subMinutes(18),
        'status' => TaskReportStatus::InProgress,
    ]);

    $this->actingAs($user)
        ->post(route('tasks.finish', $task), [
            'finished_photo' => UploadedFile::fake()->image('selesai.jpg'),
            'values' => [
                'uang_masuk' => '150000',
            ],
        ])
        ->assertRedirect()
        ->assertSessionHasNoErrors();

    $report->refresh();

    expect($report->status)->toBe(TaskReportStatus::Completed)
        ->and($report->finished_at)->not->toBeNull()
        ->and($report->finished_photo)->not->toBeNull()
        ->and($report->duration_minutes)->toBeGreaterThanOrEqual(18);

    Storage::disk('local')->assertExists($report->finished_photo);

    expect(TaskReportValue::query()
        ->where('task_report_id', $report->id)
        ->where('task_additional_field_id', $field->id)
        ->value('value'))->toBe('150000');
});

test('finishing task stores integer duration for short task', function () {
    Storage::fake('local');

    $category = TaskCategory::factory()->create();
    $role = Role::factory()->create(['level' => RoleLevel::Staff]);
    $user = User::factory()->create(['role_id' => $role->id]);
    $task = Task::factory()->create([
        'task_category_id' => $category->id,
    ]);
    $task->roles()->sync([$role->id]);
    $report = TaskReport::query()->create([
        'task_id' => $task->id,
        'user_id' => $user->id,
        'period_key' => 'once',
        'started_photo' => 'task-reports/start/example.jpg',
        'started_at' => now()->subSeconds(14),
        'status' => TaskReportStatus::InProgress,
    ]);

    $this->actingAs($user)
        ->post(route('tasks.finish', $task), [
            'finished_photo' => UploadedFile::fake()->image('selesai.jpg'),
        ])
        ->assertRedirect()
        ->assertSessionHasNoErrors();

    $report->refresh();

    expect($report->duration_minutes)->toBe(0);
});

test('staff cannot start task for another role', function () {
    $category = TaskCategory::factory()->create();
    $role = Role::factory()->create(['level' => RoleLevel::Staff]);
    $otherRole = Role::factory()->create(['level' => RoleLevel::Staff]);
    $user = User::factory()->create(['role_id' => $role->id]);
    $task = Task::factory()->create([
        'task_category_id' => $category->id,
    ]);
    $task->roles()->sync([$otherRole->id]);

    $this->actingAs($user)
        ->post(route('tasks.start', $task), [
            'started_photo' => UploadedFile::fake()->image('mulai.jpg'),
        ])
        ->assertForbidden();
});

test('required additional fields are validated when starting task', function () {
    Storage::fake('local');

    $category = TaskCategory::factory()->create();
    $role = Role::factory()->create(['level' => RoleLevel::Staff]);
    $user = User::factory()->create(['role_id' => $role->id]);
    $task = Task::factory()->create([
        'task_category_id' => $category->id,
    ]);
    $task->roles()->sync([$role->id]);
    TaskAdditionalField::factory()->create([
        'task_id' => $task->id,
        'label' => 'Nama Pelanggan',
        'field_name' => 'nama_pelanggan',
        'show_when' => 'start',
        'is_required' => true,
    ]);

    $this->actingAs($user)
        ->post(route('tasks.start', $task), [
            'started_photo' => UploadedFile::fake()->image('mulai.jpg'),
            'values' => [
                'nama_pelanggan' => '',
            ],
        ])
        ->assertSessionHasErrors('values.nama_pelanggan');
});
