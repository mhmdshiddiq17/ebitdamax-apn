<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationProfile extends Model
{
    protected $fillable = [
        'organization_id',
        'excel_import_id',
        'source_sheet',
        'job_description',
        'qualification',
        'value_chain',
        'method_cost',
        'raw_payload',
    ];

    protected $casts = [
        'method_cost' => 'decimal:2',
        'raw_payload' => 'array',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function excelImport(): BelongsTo
    {
        return $this->belongsTo(ExcelImport::class);
    }
}
