<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SdmKdkmpEntry extends Model
{
    protected $fillable = [
        'nik',
        'nama_koperasi',
        'provinsi',
        'nama_kodam',
        'nama_korem',
        'nama_kodim',
        'desa',
        'kecamatan',
        'kota_kabupaten',
        'batch',
        'jumlah_karyawan',
        'catatan',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'jumlah_karyawan' => 'integer',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
