<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Inertia\Inertia;
use Inertia\Response;

class OrganizationController extends Controller
{
    public function index(): Response
    {
        $organizations = Organization::query()
            ->root()
            ->active()
            ->ordered()
            ->with('childrenRecursive')
            ->get()
            ->map(fn (Organization $organization) => $this->transformTree($organization));

        $summary = [
            'total_nodes' => Organization::query()->count(),
            'revenue_centers' => Organization::query()->where('is_revenue_center', true)->count(),
            'cost_centers' => Organization::query()->where('is_cost_center', true)->count(),
            'max_depth' => Organization::query()->max('depth'),
        ];

        return Inertia::render('Organizations/Index', [
            'organizations' => $organizations,
            'summary' => $summary,
        ]);
    }

    private function transformTree(Organization $organization): array
    {
        return [
            'id' => $organization->id,
            'parent_id' => $organization->parent_id,
            'code' => $organization->code,
            'name' => $organization->name,
            'level' => $organization->level,
            'node_type' => $organization->node_type,
            'directorate_group' => $organization->directorate_group,
            'is_revenue_center' => $organization->is_revenue_center,
            'is_cost_center' => $organization->is_cost_center,
            'depth' => $organization->depth,
            'path' => $organization->path,
            'children' => $organization->childrenRecursive
                ->map(fn (Organization $child) => $this->transformTree($child))
                ->values()
                ->all(),
        ];
    }
}