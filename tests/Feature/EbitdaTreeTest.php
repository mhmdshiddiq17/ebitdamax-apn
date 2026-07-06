<?php

use App\Models\EbitdaValue;
use App\Models\Organization;
use App\Models\User;
use App\Services\EbitdaOrganizationValueService;
use Database\Seeders\EbitdaValueSeeder;
use Database\Seeders\OrganizationSeeder;
use Inertia\Testing\AssertableInertia as Assert;

test('guests can visit the ebitda tree page while auth middleware is bypassed', function () {
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
    EbitdaValue::query()->create([
        'organization_id' => $child->id,
        'period_date' => null,
        'year' => 2026,
        'scenario' => EbitdaValue::SCENARIO_TARGET_HARIAN,
        'source_sheet' => 'Feature test',
        'revenue' => 10_000,
        'doc_variable' => 1_000,
        'doc_fixed' => 2_000,
        'ioc' => 3_000,
        'toc' => 6_000,
        'ebitda' => 4_000,
        'ebitda_margin' => 40,
    ]);

    $response = $this->get(route('ebitda-tree.index'));

    $response
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('EbitdaTree/Index')
            ->where('tree.children.0.cost_alert.has_overrun', true)
            ->where('tree.children.0.cost_alert.largest_component', 'doc_variable')
            ->where('tree.children.0.cost_alert.overrun_amount', 500_000)
            ->where('tree.children.0.scenario_values.target_tahunan.value.doc_variable', 1_500_000)
            ->where('tree.children.0.scenario_values.target_harian.value.revenue', 10_000)
            ->where('tree.children.0.scenario_values.plan_harian.source', 'empty')
            ->where('tree.children.0.scenario_values.aktual_harian.source', 'empty')
        );
});

test('root and deputy director roll up all scenarios from children and ignore direct input', function () {
    $root = ebitdaTreeTestOrganization([
        'code' => '1',
        'name' => 'Direktur Utama',
        'level' => 'Direktur Utama',
        'node_type' => 'root',
    ]);
    $deputy = ebitdaTreeTestOrganization([
        'parent_id' => $root->id,
        'code' => '1.A',
        'name' => 'Wakil Direktur Utama I',
        'level' => 'Wakil Direktur Utama',
        'node_type' => 'deputy_director',
        'depth' => 1,
        'path' => '1/1.A',
    ]);
    $director = ebitdaTreeTestOrganization([
        'parent_id' => $deputy->id,
        'code' => '1.A.1',
        'name' => 'Direktur Test',
        'level' => 'Direktorat',
        'node_type' => 'directorate',
        'depth' => 2,
        'path' => '1/1.A/1.A.1',
    ]);
    $unit = ebitdaTreeTestOrganization([
        'parent_id' => $director->id,
        'code' => '1.A.1.1',
        'name' => 'Unit Test',
        'level' => 'Unit',
        'node_type' => 'unit',
        'depth' => 3,
        'path' => '1/1.A/1.A.1/1.A.1.1',
    ]);

    ebitdaTreeTestValue($deputy, EbitdaValue::SCENARIO_DIRECT_INPUT, [
        'revenue' => 999_000,
        'doc_variable' => 1,
        'doc_fixed' => 1,
        'ioc' => 1,
    ]);

    foreach (app(EbitdaOrganizationValueService::class)->scenarioKeys() as $index => $scenario) {
        ebitdaTreeTestValue($unit, $scenario, [
            'revenue' => 100_000 + ($index * 10_000),
            'doc_variable' => 10_000 + $index,
            'doc_fixed' => 20_000 + $index,
            'ioc' => 30_000 + $index,
        ]);
    }

    $service = app(EbitdaOrganizationValueService::class);
    $rootValues = $service->scenarioValues($root, 2026);
    $deputyValues = $service->scenarioValues($deputy, 2026);

    foreach ($service->scenarioKeys() as $index => $scenario) {
        $expectedRevenue = 100_000 + ($index * 10_000);
        $expectedToc = 60_000 + ($index * 3);

        expect($deputyValues[$scenario]['source'])->toBe('calculated_from_children')
            ->and($deputyValues[$scenario]['value']['revenue'])->toBe((float) $expectedRevenue)
            ->and($deputyValues[$scenario]['value']['toc'])->toBe((float) $expectedToc)
            ->and($rootValues[$scenario]['source'])->toBe('calculated_from_children')
            ->and($rootValues[$scenario]['value']['revenue'])->toBe((float) $expectedRevenue);
    }
});

test('svp and vp nodes with active children roll up child values', function () {
    $svp = ebitdaTreeTestOrganization([
        'code' => '1.B.1',
        'name' => 'SVP Corporate Secretary',
        'level' => 'SVP',
        'node_type' => 'support_center',
    ]);
    $unit = ebitdaTreeTestOrganization([
        'parent_id' => $svp->id,
        'code' => '1.B.1.1',
        'name' => 'Sekretaris Direksi',
        'level' => 'Unit',
        'node_type' => 'unit',
        'depth' => 1,
        'path' => '1.B.1/1.B.1.1',
    ]);
    $vp = ebitdaTreeTestOrganization([
        'code' => '1.B.3',
        'name' => 'VP Internal Audit',
    ]);
    $vpUnit = ebitdaTreeTestOrganization([
        'parent_id' => $vp->id,
        'code' => '1.B.3.1',
        'name' => 'Internal Audit',
        'level' => 'Unit',
        'node_type' => 'unit',
        'depth' => 1,
        'path' => '1.B.3/1.B.3.1',
    ]);

    ebitdaTreeTestValue($svp, EbitdaValue::SCENARIO_DIRECT_INPUT, [
        'revenue' => 1_000_000,
        'doc_variable' => 1,
        'doc_fixed' => 1,
        'ioc' => 1,
    ]);
    ebitdaTreeTestValue($unit, EbitdaValue::SCENARIO_TARGET_TAHUNAN, [
        'revenue' => 250_000,
        'doc_variable' => 40_000,
        'doc_fixed' => 60_000,
        'ioc' => 100_000,
    ]);
    ebitdaTreeTestValue($vp, EbitdaValue::SCENARIO_DIRECT_INPUT, [
        'revenue' => 900_000,
        'doc_variable' => 1,
        'doc_fixed' => 1,
        'ioc' => 1,
    ]);
    ebitdaTreeTestValue($vpUnit, EbitdaValue::SCENARIO_TARGET_TAHUNAN, [
        'revenue' => 125_000,
        'doc_variable' => 10_000,
        'doc_fixed' => 20_000,
        'ioc' => 30_000,
    ]);

    $service = app(EbitdaOrganizationValueService::class);
    $resolvedValue = $service
        ->resolve($svp, 2026, EbitdaValue::SCENARIO_TARGET_TAHUNAN);
    $vpResolvedValue = $service
        ->resolve($vp, 2026, EbitdaValue::SCENARIO_TARGET_TAHUNAN);

    expect($resolvedValue['source'])->toBe('calculated_from_children')
        ->and($resolvedValue['value']['revenue'])->toBe(250_000.0)
        ->and($resolvedValue['value']['toc'])->toBe(200_000.0)
        ->and($resolvedValue['value']['ebitda'])->toBe(50_000.0)
        ->and($vpResolvedValue['source'])->toBe('calculated_from_children')
        ->and($vpResolvedValue['value']['revenue'])->toBe(125_000.0)
        ->and($vpResolvedValue['value']['toc'])->toBe(60_000.0);
});

test('regional directors use direct input when leaf and roll up when they have children', function () {
    $leafRegion = ebitdaTreeTestOrganization([
        'code' => '1.C.1',
        'name' => 'Direktur Wilayah Sumatera',
        'level' => 'Direktorat',
        'node_type' => 'regional_center',
    ]);
    $parentRegion = ebitdaTreeTestOrganization([
        'code' => '1.C.2',
        'name' => 'Direktur Wilayah Sulawesi',
        'level' => 'Direktorat',
        'node_type' => 'regional_center',
    ]);
    $regionUnit = ebitdaTreeTestOrganization([
        'parent_id' => $parentRegion->id,
        'code' => '1.C.2.1',
        'name' => 'Unit Wilayah Sulawesi',
        'level' => 'Unit',
        'node_type' => 'unit',
        'depth' => 1,
        'path' => '1.C.2/1.C.2.1',
    ]);

    ebitdaTreeTestValue($leafRegion, EbitdaValue::SCENARIO_TARGET_TAHUNAN, [
        'revenue' => 300_000,
        'doc_variable' => 20_000,
        'doc_fixed' => 30_000,
        'ioc' => 50_000,
    ]);
    ebitdaTreeTestValue($parentRegion, EbitdaValue::SCENARIO_DIRECT_INPUT, [
        'revenue' => 900_000,
        'doc_variable' => 1,
        'doc_fixed' => 1,
        'ioc' => 1,
    ]);
    ebitdaTreeTestValue($regionUnit, EbitdaValue::SCENARIO_TARGET_TAHUNAN, [
        'revenue' => 150_000,
        'doc_variable' => 10_000,
        'doc_fixed' => 20_000,
        'ioc' => 30_000,
    ]);

    $service = app(EbitdaOrganizationValueService::class);
    $leafValue = $service->resolve($leafRegion, 2026, EbitdaValue::SCENARIO_TARGET_TAHUNAN);
    $parentValue = $service->resolve($parentRegion, 2026, EbitdaValue::SCENARIO_TARGET_TAHUNAN);

    expect($leafValue['source'])->toBe('excel')
        ->and($leafValue['value']['revenue'])->toBe(300_000.0)
        ->and($parentValue['source'])->toBe('calculated_from_children')
        ->and($parentValue['value']['revenue'])->toBe(150_000.0)
        ->and($parentValue['value']['toc'])->toBe(60_000.0);
});

test('leadership rollup recalculates margin instead of summing child margins', function () {
    $director = ebitdaTreeTestOrganization([
        'code' => '1.A.2',
        'name' => 'Direktur Sumber Daya Manusia',
        'level' => 'Direktorat',
        'node_type' => 'directorate',
    ]);
    $firstUnit = ebitdaTreeTestOrganization([
        'parent_id' => $director->id,
        'code' => '1.A.2.1',
        'name' => 'HC Service',
        'level' => 'Unit',
        'node_type' => 'unit',
        'depth' => 1,
        'path' => '1.A.2/1.A.2.1',
    ]);
    $secondUnit = ebitdaTreeTestOrganization([
        'parent_id' => $director->id,
        'code' => '1.A.2.2',
        'name' => 'HC Strategy',
        'level' => 'Unit',
        'node_type' => 'unit',
        'depth' => 1,
        'path' => '1.A.2/1.A.2.2',
    ]);

    ebitdaTreeTestValue($director, EbitdaValue::SCENARIO_DIRECT_INPUT, [
        'revenue' => 9_999_999,
        'doc_variable' => 1,
        'doc_fixed' => 1,
        'ioc' => 1,
    ]);
    ebitdaTreeTestValue($firstUnit, EbitdaValue::SCENARIO_TARGET_TAHUNAN, [
        'revenue' => 100,
        'toc' => 80,
        'ebitda' => 20,
        'ebitda_margin' => 20,
    ]);
    ebitdaTreeTestValue($secondUnit, EbitdaValue::SCENARIO_TARGET_TAHUNAN, [
        'revenue' => 300,
        'toc' => 150,
        'ebitda' => 150,
        'ebitda_margin' => 50,
    ]);

    $resolvedValue = app(EbitdaOrganizationValueService::class)
        ->resolve($director, 2026, EbitdaValue::SCENARIO_TARGET_TAHUNAN);

    expect($resolvedValue['source'])->toBe('calculated_from_children')
        ->and($resolvedValue['value']['revenue'])->toBe(400.0)
        ->and($resolvedValue['value']['ebitda'])->toBe(170.0)
        ->and($resolvedValue['value']['ebitda_margin'])->toBe(42.5);
});

test('non leadership nodes keep direct input even when they have children', function () {
    $division = ebitdaTreeTestOrganization([
        'code' => '1.A.1.1',
        'name' => 'Corporate Strategy and Planning',
        'level' => 'Sub Direktorat',
        'node_type' => 'division',
    ]);
    $unit = ebitdaTreeTestOrganization([
        'parent_id' => $division->id,
        'code' => '1.A.1.1.1',
        'name' => 'Strategy Planning',
        'level' => 'Unit',
        'node_type' => 'unit',
        'depth' => 1,
        'path' => '1.A.1.1/1.A.1.1.1',
    ]);

    ebitdaTreeTestValue($division, EbitdaValue::SCENARIO_TARGET_TAHUNAN, [
        'revenue' => 800_000,
        'doc_variable' => 100_000,
        'doc_fixed' => 200_000,
        'ioc' => 300_000,
    ]);
    ebitdaTreeTestValue($unit, EbitdaValue::SCENARIO_TARGET_TAHUNAN, [
        'revenue' => 100_000,
        'doc_variable' => 10_000,
        'doc_fixed' => 20_000,
        'ioc' => 30_000,
    ]);

    $resolvedValue = app(EbitdaOrganizationValueService::class)
        ->resolve($division, 2026, EbitdaValue::SCENARIO_TARGET_TAHUNAN);

    expect($resolvedValue['source'])->toBe('excel')
        ->and($resolvedValue['value']['revenue'])->toBe(800_000.0)
        ->and($resolvedValue['value']['toc'])->toBe(600_000.0);
});

test('tree payload exposes direct target input for leadership nodes only', function () {
    $root = ebitdaTreeTestOrganization([
        'code' => '1',
        'name' => 'Direktur Utama',
        'level' => 'Direktur Utama',
        'node_type' => 'root',
    ]);
    $deputy = ebitdaTreeTestOrganization([
        'parent_id' => $root->id,
        'code' => '1.A',
        'name' => 'Wakil Direktur Utama I',
        'level' => 'Wakil Direktur Utama',
        'node_type' => 'deputy_director',
        'depth' => 1,
        'path' => '1/1.A',
    ]);
    $director = ebitdaTreeTestOrganization([
        'parent_id' => $deputy->id,
        'code' => '1.A.1',
        'name' => 'Direktur Test',
        'level' => 'Direktorat',
        'node_type' => 'directorate',
        'depth' => 2,
        'path' => '1/1.A/1.A.1',
    ]);
    $division = ebitdaTreeTestOrganization([
        'parent_id' => $director->id,
        'code' => '1.A.1.1',
        'name' => 'Corporate Strategy and Planning',
        'level' => 'Sub Direktorat',
        'node_type' => 'division',
        'depth' => 3,
        'path' => '1/1.A/1.A.1/1.A.1.1',
    ]);
    $unit = ebitdaTreeTestOrganization([
        'parent_id' => $division->id,
        'code' => '1.A.1.1.1',
        'name' => 'Strategy Planning',
        'level' => 'Unit',
        'node_type' => 'unit',
        'depth' => 4,
        'path' => '1/1.A/1.A.1/1.A.1.1/1.A.1.1.1',
    ]);

    ebitdaTreeTestValue($root, EbitdaValue::SCENARIO_DIRECT_INPUT, [
        'revenue' => 999_000_000,
        'doc_variable' => 10,
        'doc_fixed' => 20,
        'ioc' => 30,
    ]);
    ebitdaTreeTestValue($deputy, EbitdaValue::SCENARIO_DIRECT_INPUT, [
        'revenue' => 888_000_000,
        'doc_variable' => 10,
        'doc_fixed' => 20,
        'ioc' => 30,
    ]);
    ebitdaTreeTestValue($director, EbitdaValue::SCENARIO_DIRECT_INPUT, [
        'revenue' => 777_000_000,
        'doc_variable' => 10,
        'doc_fixed' => 20,
        'ioc' => 30,
    ]);
    ebitdaTreeTestValue($division, EbitdaValue::SCENARIO_TARGET_TAHUNAN, [
        'revenue' => 666_000_000,
        'doc_variable' => 100_000,
        'doc_fixed' => 200_000,
        'ioc' => 300_000,
    ]);
    ebitdaTreeTestValue($unit, EbitdaValue::SCENARIO_TARGET_TAHUNAN, [
        'revenue' => 100_000_000,
        'doc_variable' => 10_000,
        'doc_fixed' => 20_000,
        'ioc' => 30_000,
    ]);

    $tree = app(EbitdaOrganizationValueService::class)
        ->buildTree($root, 2026, EbitdaValue::SCENARIO_TARGET_TAHUNAN);
    $deputyNode = $tree['children'][0];
    $directorNode = $deputyNode['children'][0];
    $divisionNode = $directorNode['children'][0];
    $unitNode = $divisionNode['children'][0];

    expect($tree['show_direct_value_column'])->toBeTrue()
        ->and($tree['direct_value_source'])->toBe('excel')
        ->and($tree['direct_value']['revenue'])->toBe(999_000_000.0)
        ->and($tree['scenario_values'][EbitdaValue::SCENARIO_TARGET_TAHUNAN]['value']['revenue'])->toBe(666_000_000.0)
        ->and($deputyNode['show_direct_value_column'])->toBeTrue()
        ->and($deputyNode['direct_value']['revenue'])->toBe(888_000_000.0)
        ->and($directorNode['show_direct_value_column'])->toBeTrue()
        ->and($directorNode['direct_value']['revenue'])->toBe(777_000_000.0)
        ->and($divisionNode['show_direct_value_column'])->toBeFalse()
        ->and($divisionNode['direct_value']['revenue'])->toBe(0)
        ->and($unitNode['show_direct_value_column'])->toBeFalse();
});

test('leadership exact scenario values from the matrix win over child fallback values', function () {
    $director = ebitdaTreeTestOrganization([
        'code' => '1.A.8',
        'name' => 'Direktur Teknik dan Konsultan Enjiniring',
        'level' => 'Direktorat',
        'node_type' => 'directorate',
    ]);
    $unit = ebitdaTreeTestOrganization([
        'parent_id' => $director->id,
        'code' => '1.A.8.1',
        'name' => 'Teknik',
        'level' => 'Unit',
        'node_type' => 'unit',
        'depth' => 1,
        'path' => '1.A.8/1.A.8.1',
    ]);

    ebitdaTreeTestValue($director, EbitdaValue::SCENARIO_DIRECT_INPUT, [
        'revenue' => 1_000,
        'doc_variable' => 10,
        'doc_fixed' => 20,
        'ioc' => 30,
    ]);
    ebitdaTreeTestValue($director, EbitdaValue::SCENARIO_TARGET_TAHUNAN, [
        'revenue' => 5_000,
        'toc' => 2_000,
        'ebitda' => 3_000,
        'ebitda_margin' => 60,
    ]);
    ebitdaTreeTestValue($unit, EbitdaValue::SCENARIO_TARGET_TAHUNAN, [
        'revenue' => 500,
        'toc' => 400,
        'ebitda' => 100,
        'ebitda_margin' => 20,
    ]);

    $service = app(EbitdaOrganizationValueService::class);
    $resolvedValue = $service->resolve($director, 2026, EbitdaValue::SCENARIO_TARGET_TAHUNAN);
    $tree = $service->buildTree($director, 2026, EbitdaValue::SCENARIO_TARGET_TAHUNAN);

    expect($resolvedValue['source'])->toBe('excel')
        ->and($resolvedValue['value']['revenue'])->toBe(5_000.0)
        ->and($resolvedValue['value']['ebitda'])->toBe(3_000.0)
        ->and($tree['direct_value']['revenue'])->toBe(1_000.0)
        ->and($tree['scenario_values'][EbitdaValue::SCENARIO_TARGET_TAHUNAN]['value']['revenue'])->toBe(5_000.0);
});

test('ebitda value seeder imports matrix one cached values into visible scenarios and hidden direct input', function () {
    $this->seed(OrganizationSeeder::class);
    $this->seed(EbitdaValueSeeder::class);

    $root = Organization::query()
        ->where('code', '1')
        ->firstOrFail();

    $directInput = EbitdaValue::query()
        ->where('organization_id', $root->id)
        ->where('year', 2026)
        ->where('scenario', EbitdaValue::SCENARIO_DIRECT_INPUT)
        ->firstOrFail();
    $targetTahunan = EbitdaValue::query()
        ->where('organization_id', $root->id)
        ->where('year', 2026)
        ->where('scenario', EbitdaValue::SCENARIO_TARGET_TAHUNAN)
        ->firstOrFail();
    $targetHarian = EbitdaValue::query()
        ->where('organization_id', $root->id)
        ->where('year', 2026)
        ->where('scenario', EbitdaValue::SCENARIO_TARGET_HARIAN)
        ->firstOrFail();

    expect((float) $directInput->toc)->toBe(2_198_000_000.0)
        ->and((float) $directInput->ebitda)->toBe(-2_198_000_000.0)
        ->and((float) $targetTahunan->revenue)->toBe(1_000_000_000_000.0)
        ->and((float) $targetTahunan->toc)->toBe(700_000_000_000.0)
        ->and((float) $targetTahunan->ebitda)->toBe(300_000_000_000.0)
        ->and((float) $targetTahunan->ebitda_margin)->toBe(30.0)
        ->and((float) $targetHarian->revenue)->toBe(2_739_726_027.0)
        ->and((float) $targetHarian->toc)->toBe(1_917_808_219.0)
        ->and(EbitdaValue::query()
            ->where('organization_id', $root->id)
            ->where('year', 2026)
            ->whereIn('scenario', [
                EbitdaValue::SCENARIO_PLAN_HARIAN,
                EbitdaValue::SCENARIO_AKTUAL_HARIAN,
            ])
            ->exists())->toBeFalse();
});

function ebitdaTreeTestOrganization(array $attributes): Organization
{
    $code = $attributes['code'];

    return Organization::query()->create(array_replace([
        'parent_id' => null,
        'code' => $code,
        'name' => $attributes['name'] ?? "Organization {$code}",
        'slug' => str_replace('.', '-', strtolower($code)),
        'depth' => 0,
        'path' => $code,
        'level' => 'Unit',
        'node_type' => 'unit',
        'directorate_group' => null,
        'is_revenue_center' => false,
        'is_cost_center' => true,
        'is_active' => true,
        'sort_order' => (int) str_replace('.', '', preg_replace('/\D/', '', $code) ?: '1'),
    ], $attributes));
}

function ebitdaTreeTestValue(Organization $organization, string $scenario, array $attributes): EbitdaValue
{
    $revenue = (float) ($attributes['revenue'] ?? 0);
    $docVariable = (float) ($attributes['doc_variable'] ?? 0);
    $docFixed = (float) ($attributes['doc_fixed'] ?? 0);
    $ioc = (float) ($attributes['ioc'] ?? 0);
    $toc = (float) ($attributes['toc'] ?? ($docVariable + $docFixed + $ioc));
    $ebitda = (float) ($attributes['ebitda'] ?? ($revenue - $toc));
    $ebitdaMargin = array_key_exists('ebitda_margin', $attributes)
        ? $attributes['ebitda_margin']
        : ($revenue > 0 ? round(($ebitda / $revenue) * 100, 4) : null);

    return EbitdaValue::query()->create([
        'organization_id' => $organization->id,
        'period_date' => null,
        'year' => (int) ($attributes['year'] ?? 2026),
        'scenario' => $scenario,
        'source_sheet' => $attributes['source_sheet'] ?? 'Feature test',
        'revenue' => $revenue,
        'doc_variable' => $docVariable,
        'doc_fixed' => $docFixed,
        'ioc' => $ioc,
        'toc' => $toc,
        'ebitda' => $ebitda,
        'ebitda_margin' => $ebitdaMargin,
    ]);
}
