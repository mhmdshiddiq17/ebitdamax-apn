<?php

use App\Models\Organization;
use App\Models\OrganizationProfile;
use App\Models\User;
use Database\Seeders\OrganizationSeeder;
use Inertia\Testing\AssertableInertia as Assert;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('value-chain-jobdesk.index'));

    $response->assertRedirect(route('login'));
});

test('authenticated users can visit the value chain jobdesk table', function () {
    $user = User::factory()->create();

    $this->seed(OrganizationSeeder::class);

    $organization = Organization::query()
        ->where('code', '1.C')
        ->firstOrFail();

    OrganizationProfile::query()->create([
        'organization_id' => $organization->id,
        'source_sheet' => 'ValueChain',
        'job_description' => 'Mengelola tata kelola sekretariat perusahaan.',
        'qualification' => 'Memahami governance dan komunikasi korporat.',
        'value_chain' => 'Corporate governance support.',
        'method_cost' => 1250000,
    ]);

    $this->actingAs($user);

    $response = $this->get(route('value-chain-jobdesk.index'));

    $response
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('ValueChainJobdesk/Index')
            ->where('profiles.0.code', '1.C')
            ->where('profiles.0.name', 'Corporate Secretary, Legal, Internal Audit, Pengamanan, Information Technology')
            ->where('profiles.0.parent_id', $organization->parent_id)
            ->where('profiles.0.depth', $organization->depth)
            ->where('profiles.0.path', $organization->path)
            ->where('profiles.0.value_chain', 'Corporate governance support.')
            ->where('profiles.0.method_cost', 1250000)
            ->where('summary.total_profiles', 1)
            ->where('summary.with_jobdesk', 1)
            ->where('summary.with_value_chain', 1)
        );
});
