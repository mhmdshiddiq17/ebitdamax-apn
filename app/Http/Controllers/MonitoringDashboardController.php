<?php

namespace App\Http\Controllers;

use App\Services\MonitoringDashboardService;
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
}
