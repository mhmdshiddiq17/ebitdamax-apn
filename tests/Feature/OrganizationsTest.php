<?php

use App\Models\Organization;
use App\Models\OrganizationCalculation;
use App\Models\OrganizationProfile;
use App\Models\User;
use Database\Seeders\OrganizationCalculationSeeder;
use Database\Seeders\OrganizationProfileSeeder;
use Database\Seeders\OrganizationSeeder;
use Inertia\Testing\AssertableInertia as Assert;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('organizations.index'));

    $response->assertRedirect(route('login'));
});

test('authenticated users can visit the organizations tree', function () {
    $user = User::factory()->create();

    $this->seed(OrganizationSeeder::class);
    $this->actingAs($user);

    $response = $this->get(route('organizations.index'));

    $response
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Organizations/Index')
            ->where('organizations.0.code', '1')
            ->where('organizations.0.name', 'Direktur Utama')
            ->where('organizations.0.children.0.code', '1.A')
            ->where('organizations.0.children.0.name', 'Wakil Direktur Utama I')
            ->where('summary.total_nodes', 125)
        );
});

test('authenticated users can crud organizations', function () {
    $user = User::factory()->create();
    $csrfToken = 'test-token';

    $this->seed(OrganizationSeeder::class);
    $this->actingAs($user);

    $parent = Organization::query()
        ->where('code', '1.B.1')
        ->firstOrFail();

    $payload = [
        'parent_id' => $parent->id,
        'code' => '1.B.1.X',
        'name' => 'Unit Test Organization',
        'level' => 'Unit',
        'node_type' => 'test_unit',
        'directorate_group' => 'Governance',
        'is_revenue_center' => false,
        'is_cost_center' => true,
        'is_active' => true,
        'sort_order' => 999,
    ];

    $this->withSession(['_token' => $csrfToken])
        ->post(route('organizations.store'), [
            ...$payload,
            '_token' => $csrfToken,
        ])
        ->assertRedirect();

    $organization = Organization::query()
        ->where('code', '1.B.1.X')
        ->firstOrFail();

    expect($organization->parent_id)->toBe($parent->id)
        ->and($organization->path)->toBe($parent->path.'/1.B.1.X');

    $this->withSession(['_token' => $csrfToken])
        ->put(route('organizations.update', $organization), [
            ...$payload,
            '_token' => $csrfToken,
            'name' => 'Updated Test Organization',
            'sort_order' => 1000,
        ])->assertRedirect();

    $organization->refresh();

    expect($organization->name)->toBe('Updated Test Organization')
        ->and($organization->sort_order)->toBe(1000);

    $this->withSession(['_token' => $csrfToken])
        ->delete(route('organizations.destroy', $organization), [
            '_token' => $csrfToken,
        ])
        ->assertRedirect();

    $organization->refresh();

    expect($organization->is_active)->toBeFalse();
});

test('organization dependent seeders align legacy codes to the current structure', function () {
    $this->seed(OrganizationSeeder::class);
    $this->seed(OrganizationProfileSeeder::class);
    $this->seed(OrganizationCalculationSeeder::class);

    $directorate = Organization::query()
        ->where('code', '1.A.4')
        ->firstOrFail();

    $profile = OrganizationProfile::query()
        ->where('organization_id', $directorate->id)
        ->firstOrFail();

    $calculation = OrganizationCalculation::query()
        ->where('organization_id', $directorate->id)
        ->firstOrFail();

    expect(OrganizationProfile::query()->count())->toBe(Organization::query()->count())
        ->and(OrganizationCalculation::query()->count())->toBe(Organization::query()->count())
        ->and($profile->raw_payload['excel_code'])->toBe('1.B.1')
        ->and($profile->raw_payload['mapped_organization_code'])->toBe('1.A.4')
        ->and($calculation->raw_payload['excel_code'])->toBe('1.B.1')
        ->and($calculation->raw_payload['mapped_organization_code'])->toBe('1.A.4');
});
