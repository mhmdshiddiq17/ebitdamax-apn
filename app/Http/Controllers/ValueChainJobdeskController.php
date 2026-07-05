<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrganizationProfileRequest;
use App\Http\Requests\UpdateOrganizationProfileRequest;
use App\Models\Organization;
use App\Models\OrganizationProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ValueChainJobdeskController extends Controller
{
    public function index(Request $request): Response
    {
        $search = trim((string) $request->input('search', ''));
        $mode = $request->input('mode', 'all');

        $profiles = OrganizationProfile::query()
            ->select('organization_profiles.*')
            ->join('organizations', 'organizations.id', '=', 'organization_profiles.organization_id')
            ->with('organization')
            ->when($mode === 'value_chain', function ($query): void {
                $query->whereNotNull('organization_profiles.value_chain')
                    ->where('organization_profiles.value_chain', '!=', '');
            })
            ->when($mode === 'jobdesk', function ($query): void {
                $query->whereNotNull('organization_profiles.job_description')
                    ->where('organization_profiles.job_description', '!=', '');
            })
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($subQuery) use ($search): void {
                    $subQuery
                        ->where('organizations.code', 'ilike', "%{$search}%")
                        ->orWhere('organizations.name', 'ilike', "%{$search}%")
                        ->orWhere('organizations.level', 'ilike', "%{$search}%")
                        ->orWhere('organization_profiles.job_description', 'ilike', "%{$search}%")
                        ->orWhere('organization_profiles.qualification', 'ilike', "%{$search}%")
                        ->orWhere('organization_profiles.value_chain', 'ilike', "%{$search}%");
                });
            })
            ->orderBy('organizations.sort_order')
            ->limit(500)
            ->get()
            ->map(fn (OrganizationProfile $profile): array => $this->transformProfile($profile));

        $summary = [
            'total_profiles' => OrganizationProfile::query()->count(),
            'with_jobdesk' => OrganizationProfile::query()
                ->whereNotNull('job_description')
                ->where('job_description', '!=', '')
                ->count(),
            'with_value_chain' => OrganizationProfile::query()
                ->whereNotNull('value_chain')
                ->where('value_chain', '!=', '')
                ->count(),
            'total_organizations' => Organization::query()->count(),
        ];

        $organizations = Organization::query()
            ->active()
            ->ordered()
            ->get(['id', 'code', 'name', 'level']);

        return Inertia::render('ValueChainJobdesk/Index', [
            'profiles' => $profiles,
            'organizations' => $organizations,
            'summary' => $summary,
            'filters' => [
                'search' => $search,
                'mode' => $mode,
            ],
        ]);
    }

    public function store(StoreOrganizationProfileRequest $request): RedirectResponse
    {
        $payload = $this->prepareProfilePayload($request->validated());

        OrganizationProfile::query()->updateOrCreate(
            [
                'organization_id' => $payload['organization_id'],
            ],
            $payload
        );

        return back()->with('success', 'Value chain dan jobdesk berhasil disimpan.');
    }

    public function update(
        UpdateOrganizationProfileRequest $request,
        OrganizationProfile $profile
    ): RedirectResponse {
        $payload = $this->prepareProfilePayload($request->validated());

        $profile->update($payload);

        return back()->with('success', 'Value chain dan jobdesk berhasil diperbarui.');
    }

    public function destroy(OrganizationProfile $profile): RedirectResponse
    {
        $profile->delete();

        return back()->with('success', 'Value chain dan jobdesk berhasil dihapus.');
    }

    /**
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    private function prepareProfilePayload(array $payload): array
    {
        $payload['source_sheet'] = $payload['source_sheet'] ?? 'Manual CRUD';
        $payload['raw_payload'] = [
            'source' => 'manual_crud',
        ];

        return $payload;
    }

    /**
     * @return array<string, mixed>
     */
    private function transformProfile(OrganizationProfile $profile): array
    {
        $organization = $profile->organization;

        return [
            'id' => $profile->id,
            'organization_id' => $profile->organization_id,
            'parent_id' => $organization?->parent_id,
            'code' => $organization?->code,
            'name' => $organization?->name,
            'level' => $organization?->level,
            'node_type' => $organization?->node_type,
            'directorate_group' => $organization?->directorate_group,
            'is_revenue_center' => $organization?->is_revenue_center,
            'is_cost_center' => $organization?->is_cost_center,
            'depth' => $organization?->depth,
            'path' => $organization?->path,
            'source_sheet' => $profile->source_sheet,
            'job_description' => $profile->job_description,
            'qualification' => $profile->qualification,
            'value_chain' => $profile->value_chain,
            'method_cost' => $profile->method_cost !== null ? (float) $profile->method_cost : null,
        ];
    }
}
