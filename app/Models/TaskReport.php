<?php

namespace App\Models;

use App\Enums\TaskReportStatus;
use Database\Factories\TaskReportFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class TaskReport extends Model
{
    /** @use HasFactory<TaskReportFactory> */
    use HasFactory;

    protected $fillable = [
        'uuid',
        'task_id',
        'user_id',
        'started_photo',
        'finished_photo',
        'started_at',
        'finished_at',
        'duration_minutes',
        'status',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'duration_minutes' => 'integer',
        'status' => TaskReportStatus::class,
    ];

    protected static function booted(): void
    {
        static::creating(function (TaskReport $report): void {
            if (! $report->uuid) {
                $report->uuid = (string) Str::uuid();
            }
        });
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function values(): HasMany
    {
        return $this->hasMany(TaskReportValue::class);
    }
}
