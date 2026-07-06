<?php

use App\Models\EbitdaValue;
use App\Models\Organization;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('ebitda-tree.index'));

    $response->assertRedirect(route('login'));
});

test('authenticated users can visit the ebitda tree page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Organization::query()->create([
        'code' => '1',
        'name' => 'APN',
        'slug' => 'apn',
        'depth' => 0,
        'path' => '1',
        'level' => 'Root',
        'node_type' => 'root',
        'is_revenue_center' => false,
        'is_cost_center' => true,
        'is_active' => true,
        'sort_order' => 1,
    ]);

    $response = $this->get(route('ebitda-tree.index'));

    $response->assertOk();
});

test('ebitda tree nodes include cost overrun alert metadata', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $root = Organization::query()->create([
        'code' => '1',
        'name' => 'APN',
        'slug' => 'apn',
        'depth' => 0,
        'path' => '1',
        'level' => 'Root',
        'node_type' => 'root',
        'is_revenue_center' => false,
        'is_cost_center' => true,
        'is_active' => true,
        'sort_order' => 1,
    ]);

    $child = Organization::query()->create([
        'parent_id' => $root->id,
        'code' => '1.A.1',
        'name' => 'Direktur Test',
        'slug' => 'direktur-test',
        'depth' => 1,
        'path' => '1/1.A.1',
        'level' => 'Direktorat',
        'node_type' => 'directorate',
        'is_revenue_center' => false,
        'is_cost_center' => true,
        'is_active' => true,
        'sort_order' => 2,
    ]);

    EbitdaValue::query()->create([
        'organization_id' => $child->id,
        'period_date' => null,
        'year' => 2026,
        'scenario' => EbitdaValue::SCENARIO_TARGET_TAHUNAN,
        'source_sheet' => 'Feature test',
        'revenue' => 0,
        'doc_variable' => 1_500_000,
        'doc_fixed' => 200_000,
        'ioc' => 100_000,
        'toc' => 1_000_000,
        'ebitda' => -1_000_000,
        'ebitda_margin' => null,
    ]);

    $response = $this->get(route('ebitda-tree.index'));

    $response
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('EbitdaTree/Index')
            ->where('tree.children.0.cost_alert.has_overrun', true)
            ->where('tree.children.0.cost_alert.largest_component', 'doc_variable')
            ->where('tree.children.0.cost_alert.overrun_amount', 500_000)
        );
});
