<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEbitdaValueRequest;
use App\Http\Requests\UpdateEbitdaValueRequest;
use App\Models\EbitdaValue;
use App\Models\Organization;
use App\Services\EbitdaFormulaService;
use App\Services\EbitdaOrganizationValueService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class OrganizationCalculationController extends Controller
{
    public function __construct(private EbitdaOrganizationValueService $organizationValueService) {}

    public function index(Request $request): Response
    {
        $this->organizationValueService->flushCache();

        $year = (int) $request->input('year', now()->year);
        $search = trim((string) $request->input('search', ''));
        $classification = trim((string) $request->input('classification', 'all'));

        $query = EbitdaValue::query()
            ->select('ebitda_values.*')
            ->join('organizations', 'organizations.id', '=', 'ebitda_values.organization_id')
            ->with('organization')
            ->where('ebitda_values.year', $year)
            ->whereIn('ebitda_values.scenario', $this->organizationValueService->scenarioKeys())
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($subQuery) use ($search): void {
                    $subQuery
                        ->where('organizations.code', 'ilike', "%{$search}%")
                        ->orWhere('organizations.name', 'ilike', "%{$search}%")
                        ->orWhere('organizations.level', 'ilike', "%{$search}%")
                        ->orWhere('ebitda_values.classification', 'ilike', "%{$search}%");
                });
            })
            ->when($classification !== '' && $classification !== 'all', function ($query) use ($classification): void {
                $query->where('ebitda_values.classification', $classification);
            });

        $calculations = (clone $query)
            ->orderBy('organizations.sort_order')
            ->orderBy('ebitda_values.scenario')
            ->limit(500)
            ->get()
            ->map(fn (EbitdaValue $calculation): array => $this->transformCalculation($calculation));

        $summary = [
            'total_rows' => (clone $query)->count('ebitda_values.id'),
            'total_man_cost' => (float) (clone $query)->sum('ebitda_values.man_cost'),
            'total_method_cost' => (float) (clone $query)->sum('ebitda_values.method_cost'),
            'total_material_cost' => (float) (clone $query)->sum('ebitda_values.material_cost'),
            'total_machine_cost' => (float) (clone $query)->sum('ebitda_values.machine_cost'),
            'total_cost' => (float) $calculations->sum(fn (array $calculation): float => (float) $calculation['resolved_value']['toc']),
            'total_doc_variable' => (float) $calculations->sum(fn (array $calculation): float => (float) $calculation['resolved_value']['doc_variable']),
            'total_doc_fixed' => (float) $calculations->sum(fn (array $calculation): float => (float) $calculation['resolved_value']['doc_fixed']),
            'total_ioc' => (float) $calculations->sum(fn (array $calculation): float => (float) $calculation['resolved_value']['ioc']),
        ];

        $classifications = EbitdaValue::query()
            ->where('year', $year)
            ->whereIn('scenario', $this->organizationValueService->scenarioKeys())
            ->whereNotNull('classification')
            ->where('classification', '!=', '')
            ->select('classification')
            ->distinct()
            ->orderBy('classification')
            ->pluck('classification')
            ->values();

        $organizations = Organization::query()
            ->active()
            ->ordered()
            ->get(['id', 'code', 'name', 'level']);

        return Inertia::render('Calculations/Index', [
            'calculations' => $calculations,
            'organizations' => $organizations,
            'summary' => $summary,
            'classifications' => $classifications,
            'filters' => [
                'year' => $year,
                'search' => $search,
                'classification' => $classification,
            ],
        ]);
    }

    public function store(
        StoreEbitdaValueRequest $request,
        EbitdaFormulaService $formulaService
    ): RedirectResponse {
        $payload = $formulaService->calculateFromPayload($request->validated());
        $payload['source_sheet'] = $payload['source_sheet'] ?? 'Manual Calculation CRUD';

        EbitdaValue::query()->updateOrCreate(
            [
                'organization_id' => $payload['organization_id'],
                'year' => $payload['year'],
                'period_date' => $payload['period_date'] ?? null,
                'scenario' => $payload['scenario'],
            ],
            $payload
        );

        $this->organizationValueService->flushCache();

        return back()->with('success', 'Data kalkulasi berhasil disimpan.');
    }

    public function update(
        UpdateEbitdaValueRequest $request,
        EbitdaValue $calculation,
        EbitdaFormulaService $formulaService
    ): RedirectResponse {
        $payload = $formulaService->calculateFromPayload($request->validated());
        $payload['source_sheet'] = $payload['source_sheet'] ?? 'Manual Calculation CRUD';

        $calculation->update($payload);

        $this->organizationValueService->flushCache();

        return back()->with('success', 'Data kalkulasi berhasil diperbarui.');
    }

    public function destroy(EbitdaValue $calculation): RedirectResponse
    {
        $calculation->delete();

        $this->organizationValueService->flushCache();

        return back()->with('success', 'Data kalkulasi berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function transformCalculation(EbitdaValue $calculation): array
    {
        $organization = $calculation->organization;
        $rawValue = $this->organizationValueService->valueFromRow($calculation);
        $resolvedValue = $organization
            ? $this->organizationValueService->resolve($organization, (int) $calculation->year, (string) $calculation->scenario)
            : [
                'source' => 'empty',
                'value' => $rawValue,
            ];

        return [
            'id' => $calculation->id,
            'organization_id' => $calculation->organization_id,
            'year' => $calculation->year,
            'period_date' => $calculation->period_date?->toDateString(),
            'scenario' => $calculation->scenario,
            'code' => $organization?->code,
            'name' => $organization?->name,
            'level' => $organization?->level,
            'directorate_group' => $organization?->directorate_group,
            'is_revenue_center' => $organization?->is_revenue_center,
            'is_cost_center' => $organization?->is_cost_center,
            'source_sheet' => $calculation->source_sheet,
            'value_source' => $resolvedValue['source'],
            'resolved_value' => $resolvedValue['value'],
            'classification' => $calculation->classification,
            'revenue' => (float) $rawValue['revenue'],
            'man_cost' => (float) $calculation->man_cost,
            'method_cost' => (float) $calculation->method_cost,
            'material_cost' => (float) $calculation->material_cost,
            'machine_cost' => (float) $calculation->machine_cost,
            'total_cost' => (float) $rawValue['toc'],
            'doc_variable' => (float) $rawValue['doc_variable'],
            'doc_fixed' => (float) $rawValue['doc_fixed'],
            'ioc' => (float) $rawValue['ioc'],
            'ebitda' => (float) $rawValue['ebitda'],
            'ebitda_margin' => $rawValue['ebitda_margin'],
            'raw_payload' => $calculation->raw_payload,
        ];
    }
}
