<?php

use App\Models\EbitdaValue;
use App\Models\Organization;
use App\Models\User;
use App\Services\EbitdaOrganizationValueService;
use Database\Seeders\OrganizationSeeder;
use Inertia\Testing\AssertableInertia as Assert;

test('authenticated users can visit the ebitda values page', function () {
    $user = User::factory()->create();

    $this->seed(OrganizationSeeder::class);

    $organization = Organization::query()
        ->where('code', '1.B.1')
        ->firstOrFail();

    EbitdaValue::query()->create([
        'organization_id' => $organization->id,
        'year' => 2026,
        'period_date' => null,
        'scenario' => EbitdaValue::SCENARIO_TARGET_TAHUNAN,
        'source_sheet' => 'Manual CRUD',
        'classification' => 'Governance',
        'revenue' => 15000000,
        'doc_variable' => 5000000,
        'doc_fixed' => 3000000,
        'ioc' => 2000000,
        'toc' => 10000000,
        'ebitda' => 5000000,
        'ebitda_margin' => 33.3333,
        'man_cost' => 1000000,
        'method_cost' => 2000000,
        'material_cost' => 3000000,
        'machine_cost' => 4000000,
    ]);

    $this->actingAs($user);

    $response = $this->get(route('ebitda-values.index', [
        'year' => 2026,
        'scenario' => EbitdaValue::SCENARIO_TARGET_TAHUNAN,
    ]));

    $response
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('EbitdaValues/Index')
            ->where('values.data.0.organization.code', '1.B.1')
            ->where('values.data.0.revenue', 15000000)
            ->where('values.data.0.toc', 10000000)
            ->where('filters.year', 2026)
        );
});

test('authenticated users can crud ebitda values', function () {
    $user = User::factory()->create();
    $csrfToken = 'test-token';

    $this->seed(OrganizationSeeder::class);

    $organization = Organization::query()
        ->where('code', '1.B.1')
        ->firstOrFail();

    $this->actingAs($user);

    $payload = [
        'organization_id' => $organization->id,
        'year' => 2026,
        'period_date' => null,
        'scenario' => EbitdaValue::SCENARIO_TARGET_TAHUNAN,
        'source_sheet' => 'Manual CRUD',
        'classification' => 'Governance',
        'revenue' => 15000000,
        'doc_variable' => 5000000,
        'doc_fixed' => 3000000,
        'ioc' => 2000000,
        'man_cost' => 1000000,
        'method_cost' => 2000000,
        'material_cost' => 3000000,
        'machine_cost' => 4000000,
    ];

    $this->withSession(['_token' => $csrfToken])
        ->post(route('ebitda-values.store'), [
            ...$payload,
            '_token' => $csrfToken,
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    $value = EbitdaValue::query()
        ->where('organization_id', $organization->id)
        ->firstOrFail();

    expect((float) $value->toc)->toBe(10000000.0)
        ->and((float) $value->ebitda)->toBe(5000000.0);

    $this->withSession(['_token' => $csrfToken])
        ->put(route('ebitda-values.update', $value), [
            ...$payload,
            '_token' => $csrfToken,
            'revenue' => 20000000,
            'doc_variable' => 6000000,
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    $value->refresh();

    expect((float) $value->toc)->toBe(11000000.0)
        ->and((float) $value->ebitda)->toBe(9000000.0);

    $this->withSession(['_token' => $csrfToken])
        ->delete(route('ebitda-values.destroy', $value), [
            '_token' => $csrfToken,
        ])
        ->assertRedirect();

    $this->assertDatabaseMissing('ebitda_values', [
        'id' => $value->id,
    ]);
});

test('authenticated users can input direct value for ebitda tree cards', function () {
    $user = User::factory()->create();
    $csrfToken = 'test-token';

    $this->seed(OrganizationSeeder::class);

    $organization = Organization::query()
        ->where('code', '1.A.7')
        ->firstOrFail();

    $this->actingAs($user);

    $payload = [
        'organization_id' => $organization->id,
        'year' => 2026,
        'period_date' => null,
        'scenario' => EbitdaValue::SCENARIO_DIRECT_INPUT,
        'source_sheet' => 'Manual Direct Input',
        'classification' => 'Nilai Input',
        'revenue' => 500000000,
        'doc_variable' => 100000000,
        'doc_fixed' => 50000000,
        'ioc' => 25000000,
        'man_cost' => 0,
        'method_cost' => 0,
        'material_cost' => 0,
        'machine_cost' => 0,
    ];

    $this->withSession(['_token' => $csrfToken])
        ->post(route('ebitda-values.store'), [
            ...$payload,
            '_token' => $csrfToken,
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    $value = EbitdaValue::query()
        ->where('organization_id', $organization->id)
        ->where('scenario', EbitdaValue::SCENARIO_DIRECT_INPUT)
        ->firstOrFail();

    $tree = app(EbitdaOrganizationValueService::class)
        ->buildTree($organization, 2026, EbitdaValue::SCENARIO_TARGET_TAHUNAN);

    expect((float) $value->toc)->toBe(175000000.0)
        ->and((float) $value->ebitda)->toBe(325000000.0)
        ->and((float) $value->ebitda_margin)->toBe(65.0)
        ->and($tree['direct_value_source'])->toBe('excel')
        ->and($tree['direct_value']['revenue'])->toBe(500000000.0)
        ->and($tree['direct_value']['toc'])->toBe(175000000.0);

    $response = $this->get(route('ebitda-values.index', [
        'year' => 2026,
    ]));

    $response
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('values.data.0.organization.code', '1.A.7')
            ->where('values.data.0.scenario', EbitdaValue::SCENARIO_DIRECT_INPUT)
            ->where('values.data.0.source_sheet', 'Manual Direct Input')
        );
});

test('ebitda values page ignores scenario query and lists all scenarios for the year', function () {
    $user = User::factory()->create();

    $this->seed(OrganizationSeeder::class);

    $organization = Organization::query()
        ->where('code', '1.B.1')
        ->firstOrFail();

    EbitdaValue::query()->create([
        'organization_id' => $organization->id,
        'year' => 2026,
        'period_date' => null,
        'scenario' => EbitdaValue::SCENARIO_TARGET_TAHUNAN,
        'source_sheet' => 'Manual CRUD',
        'revenue' => 15000000,
        'doc_variable' => 5000000,
        'doc_fixed' => 3000000,
        'ioc' => 2000000,
        'toc' => 10000000,
        'ebitda' => 5000000,
        'ebitda_margin' => 33.3333,
    ]);
    EbitdaValue::query()->create([
        'organization_id' => $organization->id,
        'year' => 2026,
        'period_date' => null,
        'scenario' => EbitdaValue::SCENARIO_AKTUAL_HARIAN,
        'source_sheet' => 'Manual CRUD',
        'revenue' => 3000000,
        'doc_variable' => 1000000,
        'doc_fixed' => 500000,
        'ioc' => 500000,
        'toc' => 2000000,
        'ebitda' => 1000000,
        'ebitda_margin' => 33.3333,
    ]);

    $this->actingAs($user);

    $response = $this->get(route('ebitda-values.index', [
        'year' => 2026,
        'scenario' => EbitdaValue::SCENARIO_TARGET_TAHUNAN,
    ]));

    $response
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->has('values.data', 2)
            ->where('values.data.0.scenario', EbitdaValue::SCENARIO_AKTUAL_HARIAN)
            ->where('values.data.1.scenario', EbitdaValue::SCENARIO_TARGET_TAHUNAN)
        );
});

test('ebitda values page displays editable source rows and exposes parent rollup value', function () {
    $user = User::factory()->create();
    $csrfToken = 'test-token';

    $this->seed(OrganizationSeeder::class);

    $parent = Organization::query()
        ->where('code', '1.B.1')
        ->firstOrFail();
    $firstChild = Organization::query()
        ->where('code', '1.B.1.1')
        ->firstOrFail();
    $secondChild = Organization::query()
        ->where('code', '1.B.1.2')
        ->firstOrFail();

    $parentValue = EbitdaValue::query()->create([
        'organization_id' => $parent->id,
        'year' => 2026,
        'period_date' => null,
        'scenario' => EbitdaValue::SCENARIO_TARGET_TAHUNAN,
        'source_sheet' => 'Parent exact row',
        'classification' => 'Parent',
        'revenue' => 999000000,
        'doc_variable' => 0,
        'doc_fixed' => 0,
        'ioc' => 0,
        'toc' => 999000000,
        'ebitda' => 0,
        'ebitda_margin' => null,
    ]);
    EbitdaValue::query()->create([
        'organization_id' => $firstChild->id,
        'year' => 2026,
        'period_date' => null,
        'scenario' => EbitdaValue::SCENARIO_TARGET_TAHUNAN,
        'source_sheet' => 'Child row',
        'classification' => 'Child',
        'revenue' => 100000000,
        'doc_variable' => 10000000,
        'doc_fixed' => 5000000,
        'ioc' => 5000000,
        'toc' => 20000000,
        'ebitda' => 80000000,
        'ebitda_margin' => 80,
    ]);
    EbitdaValue::query()->create([
        'organization_id' => $secondChild->id,
        'year' => 2026,
        'period_date' => null,
        'scenario' => EbitdaValue::SCENARIO_TARGET_TAHUNAN,
        'source_sheet' => 'Child row',
        'classification' => 'Child',
        'revenue' => 50000000,
        'doc_variable' => 5000000,
        'doc_fixed' => 5000000,
        'ioc' => 0,
        'toc' => 10000000,
        'ebitda' => 40000000,
        'ebitda_margin' => 80,
    ]);

    $this->actingAs($user);

    $response = $this->get(route('ebitda-values.index', [
        'year' => 2026,
        'scenario' => EbitdaValue::SCENARIO_TARGET_TAHUNAN,
    ]));

    $response
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('values.data.0.organization.code', '1.B.1')
            ->where('values.data.0.value_source', 'excel')
            ->where('values.data.0.revenue', 999000000)
            ->where('values.data.0.toc', 999000000)
            ->where('values.data.0.ebitda', 0)
            ->where('values.data.0.ebitda_margin', null)
            ->where('values.data.0.resolved_value.revenue', 999000000)
            ->where('values.data.0.resolved_value.toc', 999000000)
            ->where('values.data.0.resolved_value.ebitda', 0)
            ->where('values.data.0.resolved_value.ebitda_margin', null)
        );

    $this->withSession(['_token' => $csrfToken])
        ->put(route('ebitda-values.update', $parentValue), [
            '_token' => $csrfToken,
            'organization_id' => $parent->id,
            'year' => 2026,
            'period_date' => null,
            'scenario' => EbitdaValue::SCENARIO_TARGET_TAHUNAN,
            'source_sheet' => 'Parent exact row',
            'classification' => 'Parent',
            'revenue' => 123000000,
            'doc_variable' => 10000000,
            'doc_fixed' => 5000000,
            'ioc' => 5000000,
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    $response = $this->get(route('ebitda-values.index', [
        'year' => 2026,
        'scenario' => EbitdaValue::SCENARIO_TARGET_TAHUNAN,
    ]));

    $response
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->where('values.data.0.organization.code', '1.B.1')
            ->where('values.data.0.revenue', 123000000)
            ->where('values.data.0.toc', 20000000)
            ->where('values.data.0.ebitda', 103000000)
            ->where('values.data.0.ebitda_margin', 83.7398)
            ->where('values.data.0.resolved_value.revenue', 123000000)
            ->where('values.data.0.resolved_value.toc', 20000000)
        );
});
