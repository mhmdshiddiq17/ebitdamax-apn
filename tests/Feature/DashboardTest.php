<?php

use App\Models\EbitdaValue;
use App\Models\Organization;
use App\Models\User;
use App\Services\EbitdaDashboardService;
use Database\Seeders\EbitdaValueSeeder;
use Database\Seeders\OrganizationSeeder;
use Illuminate\Support\Facades\DB;
use Inertia\Testing\AssertableInertia as Assert;

test('guests can visit the dashboard while auth middleware is bypassed', function () {
    $response = $this->get(route('dashboard'));
    $response->assertOk();
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();
    $this->seed(OrganizationSeeder::class);

    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    $response
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Dashboard/Index')
            ->where('directorates.0.code', '1.A.1')
            ->where('directorates.0.name', 'Direktur Perencanaan dan Pengembangan Bisnis')
            ->where('tree.code', '1')
            ->where('tree.show_direct_value_column', true)
            ->where('tree.direct_value_source', 'empty')
            ->has('tree.children', 19)
            ->where('tree.children.0.code', '1.A.1')
            ->where('tree.children.0.show_direct_value_column', true)
            ->where('tree.children.0.direct_value_source', 'empty')
            ->where('tree.children.0.scenario_values.target_tahunan.source', 'empty')
            ->where('tree.children.0.scenario_values.target_harian.source', 'empty')
            ->where('tree.children.18.code', '1.C.6')
        );
});

test('directorate dashboard parent values use exact matrix value when available', function () {
    $this->seed(OrganizationSeeder::class);
    $this->seed(EbitdaValueSeeder::class);

    $directorate = Organization::query()
        ->where('code', '1.A.3')
        ->firstOrFail();
    $directorateSourceValue = EbitdaValue::query()
        ->where('organization_id', $directorate->id)
        ->where('year', 2026)
        ->where('scenario', EbitdaValue::SCENARIO_TARGET_TAHUNAN)
        ->firstOrFail();
    $firstChildOrganization = Organization::query()
        ->where('code', '1.A.3.1')
        ->firstOrFail();
    $leaf = Organization::query()
        ->where('code', '1.A.3.1.1')
        ->firstOrFail();
    $firstChildSourceValue = EbitdaValue::query()
        ->where('organization_id', $firstChildOrganization->id)
        ->where('year', 2026)
        ->where('scenario', EbitdaValue::SCENARIO_TARGET_TAHUNAN)
        ->firstOrFail();
    $leafSourceValue = EbitdaValue::query()
        ->where('organization_id', $leaf->id)
        ->where('year', 2026)
        ->where('scenario', EbitdaValue::SCENARIO_TARGET_TAHUNAN)
        ->firstOrFail();

    $dashboard = app(EbitdaDashboardService::class)->directorateDashboard(
        $directorate,
        2026,
        EbitdaValue::SCENARIO_TARGET_TAHUNAN
    );

    $costBreakdownTotal = array_sum(array_column($dashboard['charts']['cost_breakdown'], 'value'));
    $firstChild = collect($dashboard['tree']['children'])
        ->firstWhere('code', '1.A.3.1');
    $leafNode = collect($firstChild['children'])
        ->firstWhere('code', '1.A.3.1.1');

    expect($dashboard['tree']['value_source'])->toBe('excel')
        ->and($dashboard['tree']['value']['toc'])->toBe((float) $directorateSourceValue->toc)
        ->and($dashboard['tree']['value']['ebitda'])->toBe((float) $directorateSourceValue->ebitda)
        ->and($dashboard['summary']['toc'])->toBe($costBreakdownTotal)
        ->and($firstChild['value_source'])->toBe('excel')
        ->and($firstChild['value']['toc'])->toBe((float) $firstChildSourceValue->toc)
        ->and($leafNode['value_source'])->toBe('excel')
        ->and($leafNode['value']['toc'])->toBe((float) $leafSourceValue->toc)
        ->and($leafNode['value']['ebitda'])->toBe((float) $leafSourceValue->ebitda);
});

test('dashboard cost alerts flag doc or ioc costs that exceed toc', function () {
    $this->seed(OrganizationSeeder::class);

    $directorateLeaf = Organization::query()
        ->where('code', '1.A.3.1.1')
        ->firstOrFail();
    $siblingLeaf = Organization::query()
        ->where('code', '1.A.4.1.1')
        ->firstOrFail();

    EbitdaValue::query()->create([
        'organization_id' => $directorateLeaf->id,
        'period_date' => null,
        'year' => 2026,
        'scenario' => EbitdaValue::SCENARIO_TARGET_TAHUNAN,
        'source_sheet' => 'Feature test',
        'revenue' => 0,
        'doc_variable' => 2_500_000,
        'doc_fixed' => 500_000,
        'ioc' => 250_000,
        'toc' => 1_000_000,
        'ebitda' => -1_000_000,
        'ebitda_margin' => null,
    ]);
    EbitdaValue::query()->create([
        'organization_id' => $siblingLeaf->id,
        'period_date' => null,
        'year' => 2026,
        'scenario' => EbitdaValue::SCENARIO_TARGET_TAHUNAN,
        'source_sheet' => 'Feature test',
        'revenue' => 0,
        'doc_variable' => 0,
        'doc_fixed' => 0,
        'ioc' => 0,
        'toc' => 1_000_000,
        'ebitda' => -1_000_000,
        'ebitda_margin' => null,
    ]);

    $dashboard = app(EbitdaDashboardService::class)->executiveDashboard(
        2026,
        EbitdaValue::SCENARIO_TARGET_TAHUNAN
    );

    $alert = collect($dashboard['alerts']['negative_ebitda'])
        ->firstWhere('code', '1.A.3');

    expect($alert)->not->toBeNull()
        ->and($alert['largest_component'])->toBe('doc_variable')
        ->and($alert['largest_component_label'])->toBe('DOC-V')
        ->and($alert['benchmark_toc'])->toBe(2_000_000.0)
        ->and($alert['overrun_amount'])->toBe(500_000.0)
        ->and(collect($alert['overrun_components'])->pluck('key')->all())->toContain('doc_variable');
});

test('executive dashboard summary and charts stay aligned with organization table rows', function () {
    $this->seed(OrganizationSeeder::class);
    $this->seed(EbitdaValueSeeder::class);

    $dashboard = app(EbitdaDashboardService::class)->executiveDashboard(
        2026,
        EbitdaValue::SCENARIO_TARGET_TAHUNAN
    );

    $directorates = collect($dashboard['directorates']);
    $tableValues = $directorates->pluck('value');
    $tableCodes = $directorates->pluck('code')->all();

    expect($dashboard['summary']['revenue'])->toBe(array_sum(array_column($tableValues->all(), 'revenue')))
        ->and($dashboard['summary']['toc'])->toBe(array_sum(array_column($tableValues->all(), 'toc')))
        ->and($dashboard['summary']['ebitda'])->toBe(array_sum(array_column($tableValues->all(), 'ebitda')))
        ->and($dashboard['tree']['value'])->toBe($dashboard['summary'])
        ->and(array_column($dashboard['tree']['children'], 'code'))->toBe($tableCodes)
        ->and(array_keys($dashboard['tree']['scenario_values']))->toBe([
            EbitdaValue::SCENARIO_TARGET_TAHUNAN,
            EbitdaValue::SCENARIO_TARGET_HARIAN,
            EbitdaValue::SCENARIO_PLAN_HARIAN,
            EbitdaValue::SCENARIO_AKTUAL_HARIAN,
        ])
        ->and(array_column($dashboard['charts']['revenue_by_directorate'], 'code'))->toBe($tableCodes)
        ->and(array_column($dashboard['charts']['ebitda_by_directorate'], 'code'))->toBe($tableCodes);
});

test('dashboard cost alerts use parent toc as the benchmark', function () {
    $this->seed(OrganizationSeeder::class);

    $childLeaf = Organization::query()
        ->where('code', '1.A.3.1.1')
        ->firstOrFail();
    $siblingLeaf = Organization::query()
        ->where('code', '1.A.4.1.1')
        ->firstOrFail();

    EbitdaValue::query()->create([
        'organization_id' => $childLeaf->id,
        'period_date' => null,
        'year' => 2026,
        'scenario' => EbitdaValue::SCENARIO_TARGET_TAHUNAN,
        'source_sheet' => 'Feature test',
        'revenue' => 0,
        'doc_variable' => 1_500_000,
        'doc_fixed' => 0,
        'ioc' => 0,
        'toc' => 1_000_000,
        'ebitda' => -1_000_000,
        'ebitda_margin' => null,
    ]);
    EbitdaValue::query()->create([
        'organization_id' => $siblingLeaf->id,
        'period_date' => null,
        'year' => 2026,
        'scenario' => EbitdaValue::SCENARIO_TARGET_TAHUNAN,
        'source_sheet' => 'Feature test',
        'revenue' => 0,
        'doc_variable' => 0,
        'doc_fixed' => 0,
        'ioc' => 0,
        'toc' => 10_000_000,
        'ebitda' => -10_000_000,
        'ebitda_margin' => null,
    ]);

    $dashboard = app(EbitdaDashboardService::class)->executiveDashboard(
        2026,
        EbitdaValue::SCENARIO_TARGET_TAHUNAN
    );

    $alert = collect($dashboard['alerts']['negative_ebitda'])
        ->firstWhere('code', '1.A.3');

    expect($alert)->toBeNull();
});

test('executive dashboard rollup uses a bounded number of queries', function () {
    $this->seed(OrganizationSeeder::class);
    $this->seed(EbitdaValueSeeder::class);

    DB::flushQueryLog();
    DB::enableQueryLog();

    app(EbitdaDashboardService::class)->executiveDashboard(
        2026,
        EbitdaValue::SCENARIO_TARGET_TAHUNAN
    );

    expect(count(DB::getQueryLog()))->toBeLessThan(12);
});
