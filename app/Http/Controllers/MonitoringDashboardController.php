<?php

namespace App\Http\Controllers;

use App\Services\MonitoringDashboardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Inertia\Inertia;
use Inertia\Response;

class MonitoringDashboardController extends Controller
{
    public function __construct(
        private readonly MonitoringDashboardService $monitoringService
    ) {}

    public function index(): Response
    {
        return Inertia::render('Monitoring/Index', $this->monitoringService->summary());
    }

    public function mapPointsMeta(): JsonResponse
    {
        return response()
            ->json($this->monitoringService->mapPointsMeta())
            ->header(
                'Cache-Control',
                'private, max-age='.MonitoringDashboardService::MAP_POINTS_CACHE_TTL_SECONDS,
            );
    }

    /**
     * Cloudflare tidak meng-gzip response bertipe application/octet-stream
     * secara default (dianggap sudah terkompresi seperti file zip/gambar),
     * padahal payload biner titik peta ini kebanyakan berisi angka kecil
     * berulang sehingga masih kompresibel (~45%). Kompresi dilakukan manual
     * di origin bila browser mendukungnya.
     */
    public function mapPointsBinary(Request $request): HttpResponse
    {
        $binary = $this->monitoringService->mapPointsBinary();
        $response = response($binary)
            ->header('Content-Type', 'application/octet-stream')
            ->header('Vary', 'Accept-Encoding')
            ->header(
                'Cache-Control',
                'private, max-age='.MonitoringDashboardService::MAP_POINTS_CACHE_TTL_SECONDS,
            );

        if (str_contains($request->header('Accept-Encoding', ''), 'gzip')) {
            $response->setContent(gzencode($binary, 6));
            $response->header('Content-Encoding', 'gzip');
        }

        return $response;
    }
}
