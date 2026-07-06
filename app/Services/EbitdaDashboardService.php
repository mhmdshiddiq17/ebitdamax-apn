<?php

namespace App\Services;

use App\Models\EbitdaValue;
use App\Models\Organization;
use Illuminate\Support\Collection;

class EbitdaDashboardService
{
    public function __construct(private EbitdaCostAlertService $costAlertService) {}

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
                'negative_ebitda' => $this->costOverrunAlerts($year, $scenario),
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
                'negative_ebitda' => $this->costOverrunAlertsFromNodes($flatNodes),
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

        $resolvedValue = $this->resolveValueFromSource(
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
            'cost_alert' => $this->costAlertService->analyze($resolvedValue['value']),
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
        $exactValue = $this->getExactOrganizationValue($organization, $year, $scenario);

        if ($exactValue !== null) {
            return $exactValue;
        }

        $organization->load([
            'children' => fn ($query) => $query->active()->ordered(),
        ]);

        $childValues = $organization->children
            ->map(fn (Organization $child) => $this->resolveOrganizationValue($child, $year, $scenario))
            ->values()
            ->all();

        return $this->resolveValueFromSource(
            exactValue: null,
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

    private function resolveValueFromSource(?array $exactValue, array $childValues): array
    {
        if ($exactValue !== null) {
            return [
                'value' => $exactValue,
                'source' => 'excel',
            ];
        }

        if (count($childValues) > 0) {
            $sum = $this->sumValues($childValues);

            if ($this->hasAnyValue($sum)) {
                return [
                    'value' => $sum,
                    'source' => 'calculated_from_children',
                ];
            }
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

    private function costOverrunAlerts(int $year, string $scenario): array
    {
        return EbitdaValue::query()
            ->with('organization')
            ->where('year', $year)
            ->where('scenario', $scenario)
            ->get()
            ->map(function (EbitdaValue $row): ?array {
                $value = $this->valueFromEbitdaRow($row);
                $alert = $this->costAlertService->analyze($value);

                if (! $alert['has_overrun']) {
                    return null;
                }

                return $this->formatCostOverrunAlert([
                    'organization_id' => $row->organization_id,
                    'code' => $row->organization?->code,
                    'name' => $row->organization?->name,
                    'level' => $row->organization?->level,
                ], $value, $alert);
            })
            ->filter()
            ->sortByDesc('overrun_amount')
            ->take(15)
            ->values()
            ->all();
    }

    private function costOverrunAlertsFromNodes(Collection $nodes): array
    {
        return $nodes
            ->map(function ($node): ?array {
                $alert = $this->costAlertService->analyze($node['value']);

                if (! $alert['has_overrun']) {
                    return null;
                }

                return $this->formatCostOverrunAlert([
                    'organization_id' => $node['id'],
                    'code' => $node['code'],
                    'name' => $node['name'],
                    'level' => $node['level'],
                ], $node['value'], $alert);
            })
            ->filter()
            ->sortByDesc('overrun_amount')
            ->take(15)
            ->values()
            ->all();
    }

    private function valueFromEbitdaRow(EbitdaValue $row): array
    {
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

    private function formatCostOverrunAlert(array $node, array $value, array $alert): array
    {
        return [
            'organization_id' => $node['organization_id'],
            'code' => $node['code'],
            'name' => $node['name'],
            'level' => $node['level'],
            'revenue' => (float) $value['revenue'],
            'doc_variable' => (float) $value['doc_variable'],
            'doc_fixed' => (float) $value['doc_fixed'],
            'ioc' => (float) $value['ioc'],
            'toc' => (float) $value['toc'],
            'ebitda' => (float) $value['ebitda'],
            'ebitda_margin' => $value['ebitda_margin'],
            'overrun_components' => $alert['components'],
            'largest_component' => $alert['largest_component'],
            'largest_component_label' => $alert['largest_component_label'],
            'largest_cost_value' => $alert['largest_cost_value'],
            'overrun_amount' => $alert['overrun_amount'],
            'overrun_ratio' => $alert['overrun_ratio'],
            'severity' => $alert['severity'],
            'analysis' => $alert['message'],
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
