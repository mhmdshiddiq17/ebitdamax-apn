<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSdmKdkmpEntryRequest;
use App\Models\SdmKdkmpEntry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SdmKdkmpEntryController extends Controller
{
    public function index(Request $request): Response
    {
        $search = trim((string) $request->input('search', ''));

        $entries = SdmKdkmpEntry::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('nama_koperasi', 'ilike', "%{$search}%")
                        ->orWhere('nik', 'ilike', "%{$search}%")
                        ->orWhere('nama_kodim', 'ilike', "%{$search}%")
                        ->orWhere('kota_kabupaten', 'ilike', "%{$search}%")
                        ->orWhere('kecamatan', 'ilike', "%{$search}%")
                        ->orWhere('provinsi', 'ilike', "%{$search}%");
                });
            })
            ->orderBy('nama_koperasi')
            ->paginate(25)
            ->through(fn (SdmKdkmpEntry $entry): array => [
                'id' => $entry->id,
                'nik' => $entry->nik,
                'nama_koperasi' => $entry->nama_koperasi,
                'provinsi' => $entry->provinsi,
                'kota_kabupaten' => $entry->kota_kabupaten,
                'kecamatan' => $entry->kecamatan,
                'jumlah_karyawan' => $entry->jumlah_karyawan,
                'updated_at' => $entry->updated_at?->toIso8601String(),
            ])
            ->withQueryString();

        $summary = [
            'jumlah_kdkmp_ditambahkan' => SdmKdkmpEntry::query()->where('jumlah_karyawan', '>', 0)->count(),
            'total_karyawan' => (int) SdmKdkmpEntry::query()->sum('jumlah_karyawan'),
        ];

        return Inertia::render('SdmData/Index', [
            'entries' => $entries,
            'summary' => $summary,
            'filters' => [
                'search' => $search,
            ],
        ]);
    }

    public function update(UpdateSdmKdkmpEntryRequest $request, SdmKdkmpEntry $sdm_data): RedirectResponse
    {
        $sdm_data->update([
            'jumlah_karyawan' => $request->validated('jumlah_karyawan'),
            'updated_by' => $request->user()?->id,
        ]);

        return back()->with('success', 'Jumlah karyawan berhasil disimpan.');
    }
}
