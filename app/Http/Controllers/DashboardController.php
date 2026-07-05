<?php

namespace App\Http\Controllers;

use App\Models\EbitdaValue;
use App\Models\Organization;
use App\Services\EbitdaDashboardService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __construct(
        private readonly EbitdaDashboardService $dashboardService
    ) {}

    public function index(Request $request): Response
    {
        $year = (int) $request->input('year', now()->year);

        $scenario = $request->input(
            'scenario',
            EbitdaValue::SCENARIO_TARGET_TAHUNAN
        );

        return Inertia::render(
            'Dashboard/Index',
            $this->dashboardService->executiveDashboard($year, $scenario)
        );
    }

    public function showDirectorate(Request $request, Organization $organization): Response
    {
        $year = (int) $request->input('year', now()->year);

        $scenario = $request->input(
            'scenario',
            EbitdaValue::SCENARIO_TARGET_TAHUNAN
        );

        return Inertia::render(
            'Dashboard/Directorate',
            $this->dashboardService->directorateDashboard($organization, $year, $scenario)
        );
    }
}