<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSdmKdkmpEntryRequest;
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
            ->when($search !== '', fn ($query) => $query->where('nama_koperasi', 'ilike', "%{$search}%"))
            ->orderBy('nama_koperasi')
            ->get()
            ->map(fn (SdmKdkmpEntry $entry): array => [
                'id' => $entry->id,
                'nama_koperasi' => $entry->nama_koperasi,
                'jumlah_karyawan' => $entry->jumlah_karyawan,
                'catatan' => $entry->catatan,
                'updated_at' => $entry->updated_at?->toIso8601String(),
            ]);

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

    public function store(StoreSdmKdkmpEntryRequest $request): RedirectResponse
    {
        SdmKdkmpEntry::query()->create([
            ...$request->validated(),
            'created_by' => $request->user()?->id,
            'updated_by' => $request->user()?->id,
        ]);

        return back()->with('success', 'Data SDM KDKMP berhasil ditambahkan.');
    }

    public function update(StoreSdmKdkmpEntryRequest $request, SdmKdkmpEntry $sdm_data): RedirectResponse
    {
        $sdm_data->update([
            ...$request->validated(),
            'updated_by' => $request->user()?->id,
        ]);

        return back()->with('success', 'Data SDM KDKMP berhasil diperbarui.');
    }

    public function destroy(SdmKdkmpEntry $sdm_data): RedirectResponse
    {
        $sdm_data->delete();

        return back()->with('success', 'Data SDM KDKMP berhasil dihapus.');
    }
}
