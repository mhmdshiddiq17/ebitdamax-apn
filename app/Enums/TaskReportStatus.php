<?php

namespace App\Enums;

enum TaskReportStatus: string
{
    case Pending = 'pending';
    case InProgress = 'in_progress';
    case Completed = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Belum Dimulai',
            self::InProgress => 'Sedang Dikerjakan',
            self::Completed => 'Selesai',
        };
    }
}
