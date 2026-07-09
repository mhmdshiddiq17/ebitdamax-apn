<?php

namespace App\Services;

use App\Models\KdkmpOperationalEntry;
use App\Models\SdmKdkmpEntry;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MonitoringDashboardService
{
    private const CACHE_TTL_SECONDS = 600;

    private const MAP_POINTS_CACHE_TTL_SECONDS = 1800;

    private const MAP_POINTS_PAGE_SIZE = 500;

    public function summary(): array
    {
        return [
            'sarpras' => $this->sarprasCompletionSummary(),
            'pemetaan_lahan' => $this->pemetaanLahanStats(),
            'sdm' => $this->sdmSummary(),
            'operasional_odoo' => $this->operasionalOdooSummary(),
            'stock' => $this->stockSummary(),
            'produk_subsidi' => $this->produkSubsidiSummary(),
        ];
    }

    /**
     * Placeholder stock summary. Replace with Odoo integration.
     *
     * @return array{stock_berputar: int, active_sku: int, jumlah_sku: int}
     */
    public function stockSummary(): array
    {
        return [
            'stock_berputar' => 12450,
            'active_sku' => 482,
            'jumlah_sku' => 615,
        ];
    }

    /**
     * Placeholder produk subsidi summary. Replace with Odoo integration.
     *
     * @return array{total_sku_subsidi: int, availability: array{gerai: float, kabupaten: float, provinsi: float, nasional: float}}
     */
    public function produkSubsidiSummary(): array
    {
        return [
            'total_sku_subsidi' => 38,
            'availability' => [
                'gerai' => 72.4,
                'kabupaten' => 80.1,
                'provinsi' => 85.6,
                'nasional' => 89.2,
            ],
        ];
    }

    /**
     * @return array{status: 'ok'|'error', data: array|null, fetched_at: string|null}
     */
    public function sarprasCompletionSummary(): array
    {
        return $this->fetchExternal(
            cacheKey: 'monitoring:sarpras-completion-summary',
            url: rtrim(config('services.portal_pembangunan.base_url'), '/').'/api/laporan-vendor/sarpras-completion-summary',
            token: config('services.portal_pembangunan.sarpras_token'),
        );
    }

    /**
     * @return array{status: 'ok'|'error', data: array|null, fetched_at: string|null}
     */
    public function pemetaanLahanStats(): array
    {
        return $this->fetchExternal(
            cacheKey: 'monitoring:pemetaan-lahan-stats',
            url: rtrim(config('services.portal_pemetaan.base_url'), '/').'/api/validasi-lahan/get-stats',
        );
    }

    public function sdmSummary(): array
    {
        return [
            'jumlah_kdkmp_ditambahkan' => SdmKdkmpEntry::query()->where('jumlah_karyawan', '>', 0)->count(),
            'total_karyawan' => (int) SdmKdkmpEntry::query()->sum('jumlah_karyawan'),
        ];
    }

    /**
     * @return array{total_kdkmp: int, kdkmp_sudah_dibuatkan_po: int, kdkmp_sudah_penerimaan_barang: int, kdkmp_sudah_penjualan: int, updated_at: string|null}
     */
    public function operasionalOdooSummary(): array
    {
        $lastImportedEntry = KdkmpOperationalEntry::query()
            ->whereNotNull('imported_at')
            ->latest('imported_at')
            ->first();

        return [
            'total_kdkmp' => KdkmpOperationalEntry::query()->count(),
            'kdkmp_sudah_dibuatkan_po' => KdkmpOperationalEntry::query()->where('has_po', true)->count(),
            'kdkmp_sudah_penerimaan_barang' => KdkmpOperationalEntry::query()->where('has_receipt', true)->count(),
            'kdkmp_sudah_penjualan' => KdkmpOperationalEntry::query()->where('has_sales', true)->count(),
            'updated_at' => $lastImportedEntry?->imported_at?->toIso8601String(),
        ];
    }

    /**
     * Urutan tuple `points` yang dikembalikan mapPoints(). Harus selaras dengan
     * MapPointTuple di resources/js/types/monitoring.ts.
     */
    public const MAP_POINT_FIELDS = [
        'nik', 'nama_koperasi', 'provinsi', 'kota_kabupaten', 'kecamatan', 'kodim',
        'lat', 'lng', 'validation_status', 'progress_percentage', 'completed_sarpras_count',
        'sarpras_primary_lengkap', 'sarpras_secondary_lengkap', 'sarpras_lengkap',
        'jumlah_karyawan', 'has_po', 'has_receipt', 'has_sales', 'marker_tier', 'marker_color',
    ];

    /**
     * Titik peta pemetaan lahan, satu titik per pengajuan lahan terverifikasi.
     * Setiap titik diprioritaskan ke tahap paling lanjut yang sudah dicapai:
     * Odoo (PO/GR/penjualan) > SDM > sarpras > status verifikasi/pembangunan.
     *
     * `points` adalah array tuple posisional (lihat MAP_POINT_FIELDS), bukan
     * object berkey, biar payload ~35 ribu titik gak bengkak karena nama field
     * keulang-ulang.
     *
     * @return array{status: 'ok'|'error', points: array, fetched_at: string|null}
     */
    public function mapPoints(): array
    {
        $cacheKey = 'monitoring:koperasi-sarpras-status-points';

        return Cache::remember($cacheKey, self::MAP_POINTS_CACHE_TTL_SECONDS, function (): array {
            $token = config('services.portal_pembangunan.sarpras_token');
            $baseUrl = rtrim(config('services.portal_pembangunan.base_url'), '/').'/api/koperasi-sarpras-status';

            $rawPoints = [];

            try {
                $page = 1;
                do {
                    $response = Http::timeout(30)
                        ->withToken($token)
                        ->get($baseUrl, ['page' => $page, 'per_page' => self::MAP_POINTS_PAGE_SIZE]);

                    if (! $response->successful()) {
                        Log::warning("Monitoring dashboard: non-200 from {$baseUrl} page {$page}", ['status' => $response->status()]);

                        return ['status' => 'error', 'points' => [], 'fetched_at' => null];
                    }

                    $body = $response->json();
                    $rawPoints = [...$rawPoints, ...($body['data'] ?? [])];

                    $hasMore = (bool) ($body['meta']['has_more'] ?? false);
                    $page++;
                } while ($hasMore);
            } catch (\Throwable $e) {
                Log::error("Monitoring dashboard: failed to fetch map points: {$e->getMessage()}");

                return ['status' => 'error', 'points' => [], 'fetched_at' => null];
            }

            $niks = array_values(array_unique(array_filter(array_column($rawPoints, 'nik_koperasi'))));

            $sdmByNik = SdmKdkmpEntry::query()
                ->whereIn('nik', $niks)
                ->pluck('jumlah_karyawan', 'nik');

            $odooByNik = KdkmpOperationalEntry::query()
                ->whereIn('nik', $niks)
                ->get(['nik', 'has_po', 'has_receipt', 'has_sales'])
                ->keyBy('nik');

            $points = array_map(
                fn (array $point): array => $this->buildMapPoint($point, $sdmByNik, $odooByNik),
                array_values(array_filter($rawPoints, fn (array $point): bool => $point['latitude'] !== null && $point['longitude'] !== null)),
            );

            return [
                'status' => 'ok',
                'points' => $points,
                'fetched_at' => now()->toIso8601String(),
            ];
        });
    }

    /**
     * @param  array<string, int>  $sdmByNik
     * @param  Collection<string, KdkmpOperationalEntry>  $odooByNik
     * @return array<string, mixed>
     */
    /**
     * Dikembalikan sebagai tuple posisional (bukan object berkey) supaya payload
     * gak bengkak ~35 ribu titik x nama field. Urutan HARUS selaras dengan
     * MAP_POINT_FIELDS dan tipe MapPoint di resources/js/types/monitoring.ts.
     */
    private function buildMapPoint(array $point, $sdmByNik, $odooByNik): array
    {
        $nik = $point['nik_koperasi'] ?? null;
        $progress = (float) ($point['progress_percentage'] ?? 0);
        $jumlahKaryawan = $nik ? (int) ($sdmByNik[$nik] ?? 0) : 0;
        $odoo = $nik ? $odooByNik->get($nik) : null;

        [$tier, $color] = $this->resolveMarker($point, $progress, $jumlahKaryawan, $odoo);

        return [
            $nik,
            $point['koperasi_name'] ?? null,
            $point['province_name'] ?? null,
            $point['city_name'] ?? null,
            $point['district_name'] ?? null,
            $point['kodim_name'] ?? null,
            round((float) $point['latitude'], 6),
            round((float) $point['longitude'], 6),
            $point['validation_status'] ?? null,
            round($progress, 1),
            (int) ($point['completed_sarpras_count'] ?? 0),
            (bool) ($point['sarpras_primary_lengkap'] ?? false),
            (bool) ($point['sarpras_secondary_lengkap'] ?? false),
            (bool) ($point['sarpras_lengkap'] ?? false),
            $jumlahKaryawan,
            (bool) ($odoo?->has_po ?? false),
            (bool) ($odoo?->has_receipt ?? false),
            (bool) ($odoo?->has_sales ?? false),
            $tier,
            $color,
        ];
    }

    /**
     * @return array{0: 'status'|'sarpras'|'sdm'|'odoo', 1: 'red'|'orange'|'yellow'|'green'|'blue'|'gray'}
     */
    private function resolveMarker(array $point, float $progress, int $jumlahKaryawan, ?KdkmpOperationalEntry $odoo): array
    {
        // Tier 3: sudah ada progres Odoo (PO/GR/penjualan) - paling prioritas diawasi
        if ($odoo && ($odoo->has_po || $odoo->has_receipt || $odoo->has_sales)) {
            $color = match (true) {
                $odoo->has_sales => 'blue',
                $odoo->has_receipt => 'green',
                default => 'yellow',
            };

            return ['odoo', $color];
        }

        // Tier 2: SDM sudah ditambahkan
        if ($jumlahKaryawan > 0) {
            return ['sdm', $jumlahKaryawan >= 6 ? 'green' : 'yellow'];
        }

        // Tier 1: pembangunan 100%, fokus jadi kelengkapan sarpras
        if ($progress >= 100) {
            $color = match (true) {
                (bool) ($point['sarpras_lengkap'] ?? false) => 'blue',
                (bool) ($point['sarpras_secondary_lengkap'] ?? false) => 'green',
                (bool) ($point['sarpras_primary_lengkap'] ?? false) => 'yellow',
                default => 'red',
            };

            return ['sarpras', $color];
        }

        // Tier 0: status verifikasi/pembangunan
        $status = $point['validation_status'] ?? null;

        return match (true) {
            $status === 'Sedang Diverifikasi' => ['status', 'yellow'],
            $status === 'Dipertimbangkan' => ['status', 'orange'],
            $status === 'Terverifikasi' && $progress > 0 => ['status', 'green'],
            $status === 'Terverifikasi' => ['status', 'red'],
            default => ['status', 'gray'],
        };
    }

    /**
     * @return array{status: 'ok'|'error', data: array|null, fetched_at: string|null}
     */
    private function fetchExternal(string $cacheKey, string $url, ?string $token = null): array
    {
        return Cache::remember($cacheKey, self::CACHE_TTL_SECONDS, function () use ($url, $token): array {
            try {
                $request = Http::timeout(10);

                if ($token) {
                    $request = $request->withToken($token);
                }

                $response = $request->get($url);

                if (! $response->successful()) {
                    Log::warning("Monitoring dashboard: non-200 from {$url}", ['status' => $response->status()]);

                    return ['status' => 'error', 'data' => null, 'fetched_at' => null];
                }

                return [
                    'status' => 'ok',
                    'data' => $response->json(),
                    'fetched_at' => now()->toIso8601String(),
                ];
            } catch (\Throwable $e) {
                Log::error("Monitoring dashboard: failed to fetch {$url}: {$e->getMessage()}");

                return ['status' => 'error', 'data' => null, 'fetched_at' => null];
            }
        });
    }
}
