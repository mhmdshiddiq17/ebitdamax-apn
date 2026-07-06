<?php

use App\Models\Organization;
use App\Models\OrganizationProfile;
use App\Models\User;
use Database\Seeders\OrganizationSeeder;
use Inertia\Testing\AssertableInertia as Assert;

test('guests can visit value chain jobdesk while auth middleware is bypassed', function () {
    $response = $this->get(route('value-chain-jobdesk.index'));

    $response->assertOk();
});

test('authenticated users can visit the value chain jobdesk table', function () {
    $user = User::factory()->create();

    $this->seed(OrganizationSeeder::class);

    $organization = Organization::query()
        ->where('code', '1.B.1')
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
            ->where('profiles.0.code', '1.B.1')
            ->where('profiles.0.name', 'SVP Corporate Secretary')
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

test('authenticated users can crud value chain jobdesk profiles', function () {
    $user = User::factory()->create();
    $csrfToken = 'test-token';

    $this->seed(OrganizationSeeder::class);

    $organization = Organization::query()
        ->where('code', '1.B.1')
        ->firstOrFail();

    $this->actingAs($user);

    $payload = [
        'organization_id' => $organization->id,
        'source_sheet' => 'Manual CRUD',
        'job_description' => 'Mengelola tata kelola sekretariat perusahaan.',
        'qualification' => 'Memahami governance dan komunikasi korporat.',
        'value_chain' => 'Corporate governance support.',
        'method_cost' => 1250000,
    ];

    $this->withSession(['_token' => $csrfToken])
        ->post(route('value-chain-jobdesk.store'), [
            ...$payload,
            '_token' => $csrfToken,
        ])
        ->assertRedirect();

    $profile = OrganizationProfile::query()
        ->where('organization_id', $organization->id)
        ->firstOrFail();

    expect($profile->job_description)->toBe($payload['job_description']);

    $this->withSession(['_token' => $csrfToken])
        ->put(route('value-chain-jobdesk.update', $profile), [
            ...$payload,
            '_token' => $csrfToken,
            'method_cost' => 1750000,
        ])->assertRedirect();

    $profile->refresh();

    expect((float) $profile->method_cost)->toBe(1750000.0);

    $this->withSession(['_token' => $csrfToken])
        ->delete(route('value-chain-jobdesk.destroy', $profile), [
            '_token' => $csrfToken,
        ])
        ->assertRedirect();

    $this->assertDatabaseMissing('organization_profiles', [
        'id' => $profile->id,
    ]);
});
