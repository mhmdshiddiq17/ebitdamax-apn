<?php

namespace App\Console\Commands;

use App\Models\KoperasiSarprasStatusPoint;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

#[Signature('sync:koperasi-sarpras-status')]
#[Description('Sinkronkan titik peta koperasi (sarpras/verifikasi/pembangunan) dari portal pembangunan ke database lokal, dipanggil scheduler.')]
class SyncKoperasiSarprasStatusCommand extends Command
{
    private const PAGE_SIZE = 500;

    public function handle(): int
    {
        $token = config('services.portal_pembangunan.sarpras_token');
        $baseUrl = rtrim(config('services.portal_pembangunan.base_url'), '/').'/api/koperasi-sarpras-status';

        if (! $token) {
            $this->error('PORTAL_PEMBANGUNAN_SARPRAS_TOKEN belum di-set.');

            return self::FAILURE;
        }

        $syncedAt = now();
        $upserted = 0;
        $page = 1;

        $this->info('Sinkronisasi titik koperasi mulai...');

        do {
            $response = Http::timeout(30)
                ->withToken($token)
                ->get($baseUrl, ['page' => $page, 'per_page' => self::PAGE_SIZE]);

            if (! $response->successful()) {
                $this->error("Gagal ambil halaman {$page}: HTTP {$response->status()}");

                return self::FAILURE;
            }

            $body = $response->json();
            $rows = $body['data'] ?? [];

            $records = collect($rows)
                ->filter(fn (array $row): bool => $row['latitude'] !== null && $row['longitude'] !== null)
                ->map(fn (array $row): array => [
                    'nik' => $row['nik_koperasi'] ?? null,
                    'nama_koperasi' => $row['koperasi_name'] ?? null,
                    'provinsi' => $row['province_name'] ?? null,
                    'kota_kabupaten' => $row['city_name'] ?? null,
                    'kecamatan' => $row['district_name'] ?? null,
                    'desa' => $row['village_name'] ?? null,
                    'kodim' => $row['kodim_name'] ?? null,
                    'lat' => round((float) $row['latitude'], 6),
                    'lng' => round((float) $row['longitude'], 6),
                    'validation_status' => $row['validation_status'] ?? null,
                    'progress_percentage' => round((float) ($row['progress_percentage'] ?? 0), 1),
                    'batch' => $row['batch'] ?? null,
                    'completed_sarpras_count' => (int) ($row['completed_sarpras_count'] ?? 0),
                    'sarpras_less_than_6' => (bool) ($row['sarpras_less_than_6'] ?? true),
                    'sarpras_primary_lengkap' => (bool) ($row['sarpras_primary_lengkap'] ?? false),
                    'sarpras_secondary_lengkap' => (bool) ($row['sarpras_secondary_lengkap'] ?? false),
                    'sarpras_lengkap' => (bool) ($row['sarpras_lengkap'] ?? false),
                    'synced_at' => $syncedAt,
                    'updated_at' => $syncedAt,
                    'created_at' => $syncedAt,
                ])
                ->values()
                ->all();

            foreach (array_chunk($records, 500) as $chunk) {
                KoperasiSarprasStatusPoint::query()->upsert(
                    $chunk,
                    uniqueBy: ['nik', 'lat', 'lng'],
                    update: [
                        'nama_koperasi', 'provinsi', 'kota_kabupaten', 'kecamatan', 'desa', 'kodim',
                        'validation_status', 'progress_percentage', 'batch', 'completed_sarpras_count',
                        'sarpras_less_than_6', 'sarpras_primary_lengkap', 'sarpras_secondary_lengkap',
                        'sarpras_lengkap', 'synced_at', 'updated_at',
                    ],
                );
            }

            $upserted += count($records);
            $hasMore = (bool) ($body['meta']['has_more'] ?? false);
            $this->info("Halaman {$page} selesai ({$upserted} titik).");
            $page++;
        } while ($hasMore);

        $staleDeleted = KoperasiSarprasStatusPoint::query()
            ->where('synced_at', '<', $syncedAt)
            ->delete();

        $this->info("Selesai. {$upserted} titik disinkronkan, {$staleDeleted} titik lama (tidak ada di sync ini) dihapus.");

        return self::SUCCESS;
    }
}
