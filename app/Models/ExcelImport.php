<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExcelImport extends Model
{
    protected $fillable = [
        'filename',
        'original_filename',
        'status',
        'total_rows',
        'success_rows',
        'failed_rows',
        'created_by',
    ];

    public function errors(): HasMany
    {
        return $this->hasMany(ImportErrorLog::class);
    }
}