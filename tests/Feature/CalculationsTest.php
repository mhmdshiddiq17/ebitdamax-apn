<?php

use App\Models\EbitdaValue;
use App\Models\Organization;
use App\Models\User;
use Database\Seeders\OrganizationSeeder;
use Inertia\Testing\AssertableInertia as Assert;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('calculations.index'));

    $response->assertRedirect(route('login'));
});

test('authenticated users can visit the calculations page', function () {
    $user = User::factory()->create();

    $this->seed(OrganizationSeeder::class);

    $organization = Organization::query()
        ->where('code', '1.C')
        ->firstOrFail();

    EbitdaValue::query()->create([
        'organization_id' => $organization->id,
        'year' => 2026,
        'period_date' => null,
        'scenario' => EbitdaValue::SCENARIO_TARGET_TAHUNAN,
        'source_sheet' => 'Seeder from organization_calculations',
        'classification' => 'Governance',
        'revenue' => 0,
        'man_cost' => 1000000,
        'method_cost' => 2000000,
        'material_cost' => 3000000,
        'machine_cost' => 4000000,
        'toc' => 10000000,
        'doc_variable' => 5000000,
        'doc_fixed' => 3000000,
        'ioc' => 2000000,
        'ebitda' => -10000000,
        'ebitda_margin' => null,
    ]);

    $this->actingAs($user);

    $response = $this->get(route('calculations.index', [
        'year' => 2026,
        'scenario' => EbitdaValue::SCENARIO_TARGET_TAHUNAN,
        'classification' => 'Governance',
    ]));

    $response
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Calculations/Index')
            ->where('calculations.0.code', '1.C')
            ->where('calculations.0.name', 'Corporate Secretary, Legal, Internal Audit, Pengamanan, Information Technology')
            ->where('calculations.0.year', 2026)
            ->where('calculations.0.scenario', EbitdaValue::SCENARIO_TARGET_TAHUNAN)
            ->where('calculations.0.classification', 'Governance')
            ->where('calculations.0.total_cost', 10000000)
            ->where('summary.total_rows', 1)
            ->where('summary.total_cost', 10000000)
            ->where('classifications.0', 'Governance')
            ->where('filters.year', 2026)
            ->where('filters.scenario', EbitdaValue::SCENARIO_TARGET_TAHUNAN)
            ->where('filters.classification', 'Governance')
        );
});

test('authenticated users can crud calculations through ebitda values', function () {
    $user = User::factory()->create();
    $csrfToken = 'test-token';

    $this->seed(OrganizationSeeder::class);

    $organization = Organization::query()
        ->where('code', '1.C')
        ->firstOrFail();

    $this->actingAs($user);

    $payload = [
        'organization_id' => $organization->id,
        'year' => 2026,
        'period_date' => null,
        'scenario' => EbitdaValue::SCENARIO_TARGET_TAHUNAN,
        'source_sheet' => 'Manual Calculation CRUD',
        'classification' => 'Governance',
        'revenue' => 10000000,
        'man_cost' => 1000000,
        'method_cost' => 2000000,
        'material_cost' => 3000000,
        'machine_cost' => 4000000,
        'doc_variable' => 5000000,
        'doc_fixed' => 3000000,
        'ioc' => 2000000,
    ];

    $this->withSession(['_token' => $csrfToken])
        ->post(route('calculations.store'), [
            ...$payload,
            '_token' => $csrfToken,
        ])
        ->assertRedirect();

    $calculation = EbitdaValue::query()
        ->where('organization_id', $organization->id)
        ->firstOrFail();

    expect((float) $calculation->toc)->toBe(10000000.0)
        ->and((float) $calculation->ebitda)->toBe(0.0);

    $this->withSession(['_token' => $csrfToken])
        ->put(route('calculations.update', $calculation), [
            ...$payload,
            '_token' => $csrfToken,
            'revenue' => 15000000,
            'ioc' => 1000000,
        ])->assertRedirect();

    $calculation->refresh();

    expect((float) $calculation->toc)->toBe(9000000.0)
        ->and((float) $calculation->ebitda)->toBe(6000000.0);

    $this->withSession(['_token' => $csrfToken])
        ->delete(route('calculations.destroy', $calculation), [
            '_token' => $csrfToken,
        ])
        ->assertRedirect();

    $this->assertDatabaseMissing('ebitda_values', [
        'id' => $calculation->id,
    ]);
});
