<?php

namespace App\Models;

use Database\Factories\TaskReportValueFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class TaskReportValue extends Model
{
    /** @use HasFactory<TaskReportValueFactory> */
    use HasFactory;

    protected $fillable = [
        'uuid',
        'task_report_id',
        'task_additional_field_id',
        'value',
    ];

    protected static function booted(): void
    {
        static::creating(function (TaskReportValue $value): void {
            if (! $value->uuid) {
                $value->uuid = (string) Str::uuid();
            }
        });
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(TaskReport::class, 'task_report_id');
    }

    public function additionalField(): BelongsTo
    {
        return $this->belongsTo(TaskAdditionalField::class, 'task_additional_field_id');
    }
}
