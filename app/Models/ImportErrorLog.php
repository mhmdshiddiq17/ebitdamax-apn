<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImportErrorLog extends Model
{
    protected $fillable = [
        'excel_import_id',
        'row_number',
        'sheet_name',
        'message',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public function excelImport(): BelongsTo
    {
        return $this->belongsTo(ExcelImport::class);
    }
}