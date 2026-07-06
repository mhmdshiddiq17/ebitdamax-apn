<?php

namespace App\Http\Controllers;

use App\Models\EbitdaValue;
use App\Models\Organization;
use App\Services\EbitdaCostAlertService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EbitdaTreeController extends Controller
{
    public function __construct(private EbitdaCostAlertService $costAlertService) {}

    public function index(Request $request): Response
    {
        $year = (int) $request->input('year', now()->year);

        $scenario = $request->input(
            'scenario',
            EbitdaValue::SCENARIO_TARGET_TAHUNAN
        );

        $rootSlug = $request->input('root');

        $rootOrganization = $rootSlug
            ? Organization::query()->where('slug', $rootSlug)->first()
            : Organization::query()->where('code', '1')->first();

        if (! $rootOrganization) {
            $rootOrganization = Organization::query()->root()->firstOrFail();
        }

        $tree = $this->buildTreeWithValues($rootOrganization, $year, $scenario);

        $treeOptions = Organization::query()
            ->where(function ($query) {
                $query->whereNull('parent_id')
                    ->orWhere('level', 'Direktorat')
                    ->orWhere('level', 'Wakil Direktur Utama');
            })
            ->active()
            ->ordered()
            ->get()
            ->map(fn (Organization $organization) => [
                'id' => $organization->id,
                'slug' => $organization->slug,
                'code' => $organization->code,
                'name' => $organization->name,
                'level' => $organization->level,
            ]);

        return Inertia::render('EbitdaTree/Index', [
            'year' => $year,
            'scenario' => $scenario,
            'selectedRoot' => $rootOrganization->slug,
            'treeOptions' => $treeOptions,
            'tree' => $tree,
        ]);
    }

    private function buildTreeWithValues(Organization $organization, int $year, string $scenario): array
    {
        $organization->load([
            'children' => fn ($query) => $query->active()->ordered(),
        ]);

        $children = $organization->children
            ->map(fn (Organization $child) => $this->buildTreeWithValues($child, $year, $scenario))
            ->values()
            ->all();

        /**
         * Rule penting agar sesuai Excel:
         * 1. Jika node punya nilai exact hasil import Excel, pakai nilai itu.
         * 2. Jika node tidak punya nilai exact, agregasikan dari child.
         */
        $exactValue = $this->getExactValue($organization, $year, $scenario);

        if ($exactValue !== null) {
            $value = $exactValue;
            $valueSource = 'excel';
        } elseif (count($children) > 0) {
            $value = $this->sumValues(array_column($children, 'value'));
            $valueSource = 'calculated_from_children';
        } else {
            $value = $this->emptyValue();
            $valueSource = 'empty';
        }

        return [
            'id' => $organization->id,
            'slug' => $organization->slug,
            'code' => $organization->code,
            'name' => $organization->name,
            'level' => $organization->level,
            'node_type' => $organization->node_type,
            'directorate_group' => $organization->directorate_group,
            'is_revenue_center' => $organization->is_revenue_center,
            'is_cost_center' => $organization->is_cost_center,
            'depth' => $organization->depth,
            'value_source' => $valueSource,
            'value' => $value,
            'cost_alert' => $this->costAlertService->analyze($value),
            'children' => $children,
        ];
    }

    private function getExactValue(Organization $organization, int $year, string $scenario): ?array
    {
        $row = EbitdaValue::query()
            ->where('organization_id', $organization->id)
            ->where('year', $year)
            ->where('scenario', $scenario)
            ->first();

        if (! $row) {
            return null;
        }

        return [
            'revenue' => (float) $row->revenue,
            'doc_variable' => (float) $row->doc_variable,
            'doc_fixed' => (float) $row->doc_fixed,
            'ioc' => (float) $row->ioc,
            'toc' => (float) $row->toc,
            'ebitda' => (float) $row->ebitda,
            'ebitda_margin' => $row->ebitda_margin !== null
                ? (float) $row->ebitda_margin
                : null,
        ];
    }

    private function sumValues(array $values): array
    {
        $revenue = array_sum(array_column($values, 'revenue'));
        $docVariable = array_sum(array_column($values, 'doc_variable'));
        $docFixed = array_sum(array_column($values, 'doc_fixed'));
        $ioc = array_sum(array_column($values, 'ioc'));
        $toc = array_sum(array_column($values, 'toc'));
        $ebitda = array_sum(array_column($values, 'ebitda'));

        return [
            'revenue' => $revenue,
            'doc_variable' => $docVariable,
            'doc_fixed' => $docFixed,
            'ioc' => $ioc,
            'toc' => $toc,
            'ebitda' => $ebitda,
            'ebitda_margin' => $revenue > 0
                ? round(($ebitda / $revenue) * 100, 4)
                : null,
        ];
    }

    private function emptyValue(): array
    {
        return [
            'revenue' => 0,
            'doc_variable' => 0,
            'doc_fixed' => 0,
            'ioc' => 0,
            'toc' => 0,
            'ebitda' => 0,
            'ebitda_margin' => null,
        ];
    }
}
