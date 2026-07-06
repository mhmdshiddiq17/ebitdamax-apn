<?php

namespace App\Services;

use App\Models\EbitdaValue;
use App\Models\Organization;
use Illuminate\Support\Collection;

class EbitdaDashboardService
{
    public function executiveDashboard(int $year, string $scenario): array
    {
        $directorates = Organization::query()
            ->dashboardUnits()
            ->active()
            ->ordered()
            ->get()
            ->map(function (Organization $organization) use ($year, $scenario) {
                $value = $this->resolveOrganizationValue($organization, $year, $scenario);

                return [
                    'id' => $organization->id,
                    'slug' => $organization->slug,
                    'code' => $organization->code,
                    'name' => $organization->name,
                    'level' => $organization->level,
                    'is_revenue_center' => $organization->is_revenue_center,
                    'is_cost_center' => $organization->is_cost_center,
                    'value' => $value,
                ];
            })
            ->values();

        $summary = $this->sumValues($directorates->pluck('value')->all());

        return [
            'year' => $year,
            'scenario' => $scenario,
            'summary' => $summary,
            'directorates' => $directorates,
            'charts' => [
                'revenue_by_directorate' => $this->buildRevenueChart($directorates),
                'cost_breakdown' => $this->buildCostBreakdownChart($summary),
                'ebitda_by_directorate' => $this->buildEbitdaChart($directorates),
                'margin_ranking' => $this->buildMarginRanking($directorates),
            ],
            'alerts' => [
                'negative_ebitda' => $this->negativeEbitdaAlerts($year, $scenario),
            ],
        ];
    }

    public function directorateDashboard(Organization $organization, int $year, string $scenario): array
    {
        $tree = $this->buildTreeWithValues($organization, $year, $scenario);
        $flatNodes = collect($this->flattenTree($tree));
        $children = collect($tree['children']);

        $summary = $tree['value'];

        return [
            'year' => $year,
            'scenario' => $scenario,
            'directorate' => [
                'id' => $organization->id,
                'slug' => $organization->slug,
                'code' => $organization->code,
                'name' => $organization->name,
            ],
            'summary' => $summary,
            'tree' => $tree,
            'charts' => [
                'revenue_by_directorate' => $this->buildRevenueChart($children),
                'cost_breakdown' => $this->buildCostBreakdownChart($summary),
                'ebitda_by_directorate' => $this->buildEbitdaChart($children),
                'margin_ranking' => $this->buildMarginRanking($flatNodes),
            ],
            'alerts' => [
                'negative_ebitda' => $this->negativeEbitdaAlertsFromNodes($flatNodes),
            ],
        ];
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

        $resolvedValue = $this->resolveValueFromChildren(
            exactValue: $this->getExactOrganizationValue($organization, $year, $scenario),
            childValues: array_column($children, 'value')
        );

        return [
            'id' => $organization->id,
            'slug' => $organization->slug,
            'code' => $organization->code,
            'name' => $organization->name,
            'level' => $organization->level,
            'is_revenue_center' => $organization->is_revenue_center,
            'is_cost_center' => $organization->is_cost_center,
            'value_source' => $resolvedValue['source'],
            'value' => $resolvedValue['value'],
            'children' => $children,
        ];
    }

    private function flattenTree(array $node): array
    {
        $nodes = [$node];

        foreach ($node['children'] ?? [] as $child) {
            $nodes = array_merge($nodes, $this->flattenTree($child));
        }

        return $nodes;
    }

    private function resolveOrganizationValue(Organization $organization, int $year, string $scenario): array
    {
        $organization->load([
            'children' => fn ($query) => $query->active()->ordered(),
        ]);

        $childValues = $organization->children
            ->map(fn (Organization $child) => $this->resolveOrganizationValue($child, $year, $scenario))
            ->values()
            ->all();

        return $this->resolveValueFromChildren(
            exactValue: $this->getExactOrganizationValue($organization, $year, $scenario),
            childValues: $childValues
        )['value'];
    }

    private function getExactOrganizationValue(Organization $organization, int $year, string $scenario): ?array
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
            'ebitda_margin' => $row->ebitda_margin !== null ? (float) $row->ebitda_margin : null,
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
            'ebitda_margin' => $revenue > 0 ? round(($ebitda / $revenue) * 100, 4) : null,
        ];
    }

    private function resolveValueFromChildren(?array $exactValue, array $childValues): array
    {
        if (count($childValues) > 0) {
            $sum = $this->sumValues($childValues);

            if ($this->hasAnyValue($sum)) {
                return [
                    'value' => $sum,
                    'source' => 'calculated_from_children',
                ];
            }
        }

        if ($exactValue !== null) {
            return [
                'value' => $exactValue,
                'source' => 'excel',
            ];
        }

        return [
            'value' => $this->emptyValue(),
            'source' => 'empty',
        ];
    }

    private function hasAnyValue(array $value): bool
    {
        foreach (['revenue', 'doc_variable', 'doc_fixed', 'ioc', 'toc', 'ebitda'] as $key) {
            if (abs((float) ($value[$key] ?? 0)) > 0) {
                return true;
            }
        }

        return $value['ebitda_margin'] !== null;
    }

    private function buildRevenueChart(Collection $items): array
    {
        return $items
            ->map(fn ($item) => [
                'code' => $item['code'],
                'name' => $item['name'],
                'label' => $item['code'],
                'value' => (float) $item['value']['revenue'],
            ])
            ->sortByDesc('value')
            ->values()
            ->all();
    }

    private function buildEbitdaChart(Collection $items): array
    {
        return $items
            ->map(fn ($item) => [
                'code' => $item['code'],
                'name' => $item['name'],
                'label' => $item['code'],
                'value' => (float) $item['value']['ebitda'],
            ])
            ->sortByDesc('value')
            ->values()
            ->all();
    }

    private function buildCostBreakdownChart(array $summary): array
    {
        return [
            [
                'name' => 'DOC-V',
                'label' => 'DOC Variable',
                'value' => (float) $summary['doc_variable'],
            ],
            [
                'name' => 'DOC-F',
                'label' => 'DOC Fixed',
                'value' => (float) $summary['doc_fixed'],
            ],
            [
                'name' => 'IOC',
                'label' => 'Indirect Operating Cost',
                'value' => (float) $summary['ioc'],
            ],
        ];
    }

    private function buildMarginRanking(Collection $items): array
    {
        return $items
            ->filter(fn ($item) => $item['value']['ebitda_margin'] !== null)
            ->map(fn ($item) => [
                'code' => $item['code'],
                'name' => $item['name'],
                'label' => $item['code'],
                'value' => (float) $item['value']['ebitda_margin'],
            ])
            ->sortByDesc('value')
            ->values()
            ->all();
    }

    private function negativeEbitdaAlerts(int $year, string $scenario): array
    {
        return EbitdaValue::query()
            ->with('organization')
            ->where('year', $year)
            ->where('scenario', $scenario)
            ->where('ebitda', '<', 0)
            ->orderBy('ebitda')
            ->limit(15)
            ->get()
            ->map(fn (EbitdaValue $row) => [
                'organization_id' => $row->organization_id,
                'code' => $row->organization?->code,
                'name' => $row->organization?->name,
                'level' => $row->organization?->level,
                'revenue' => (float) $row->revenue,
                'toc' => (float) $row->toc,
                'ebitda' => (float) $row->ebitda,
                'ebitda_margin' => $row->ebitda_margin !== null ? (float) $row->ebitda_margin : null,
            ])
            ->values()
            ->all();
    }

    private function negativeEbitdaAlertsFromNodes(Collection $nodes): array
    {
        return $nodes
            ->filter(fn ($node) => (float) $node['value']['ebitda'] < 0)
            ->sortBy(fn ($node) => (float) $node['value']['ebitda'])
            ->take(15)
            ->map(fn ($node) => [
                'organization_id' => $node['id'],
                'code' => $node['code'],
                'name' => $node['name'],
                'level' => $node['level'],
                'revenue' => (float) $node['value']['revenue'],
                'toc' => (float) $node['value']['toc'],
                'ebitda' => (float) $node['value']['ebitda'],
                'ebitda_margin' => $node['value']['ebitda_margin'],
            ])
            ->values()
            ->all();
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
