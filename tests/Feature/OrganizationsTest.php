<?php

use App\Models\Organization;
use App\Models\User;
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
            ->where('organizations.0.children.0.code', '1.C')
            ->where('organizations.0.children.0.name', 'Corporate Secretary, Legal, Internal Audit, Pengamanan, Information Technology')
            ->where('summary.total_nodes', 128)
        );
});

test('authenticated users can crud organizations', function () {
    $user = User::factory()->create();
    $csrfToken = 'test-token';

    $this->seed(OrganizationSeeder::class);
    $this->actingAs($user);

    $parent = Organization::query()
        ->where('code', '1.C')
        ->firstOrFail();

    $payload = [
        'parent_id' => $parent->id,
        'code' => '1.C.X',
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
        ->where('code', '1.C.X')
        ->firstOrFail();

    expect($organization->parent_id)->toBe($parent->id)
        ->and($organization->path)->toBe($parent->path.'/1.C.X');

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
