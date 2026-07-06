<?php

use App\Models\EbitdaValue;
use App\Models\Organization;
use App\Models\User;
use App\Services\EbitdaDashboardService;
use Database\Seeders\EbitdaValueSeeder;
use Database\Seeders\OrganizationCalculationSeeder;
use Database\Seeders\OrganizationSeeder;
use Inertia\Testing\AssertableInertia as Assert;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
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
        );
});

test('directorate dashboard tree breakdown uses exact ebitda values from source tables', function () {
    $this->seed(OrganizationSeeder::class);
    $this->seed(OrganizationCalculationSeeder::class);
    $this->seed(EbitdaValueSeeder::class);

    $directorate = Organization::query()
        ->where('code', '1.A.3')
        ->firstOrFail();
    $child = Organization::query()
        ->where('code', '1.A.3.1')
        ->firstOrFail();

    $directorateSourceValue = EbitdaValue::query()
        ->where('organization_id', $directorate->id)
        ->where('year', 2026)
        ->where('scenario', EbitdaValue::SCENARIO_TARGET_TAHUNAN)
        ->firstOrFail();
    $childSourceValue = EbitdaValue::query()
        ->where('organization_id', $child->id)
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

    expect($dashboard['tree']['value_source'])->toBe('excel')
        ->and($dashboard['tree']['value']['toc'])->toBe((float) $directorateSourceValue->toc)
        ->and($dashboard['tree']['value']['ebitda'])->toBe((float) $directorateSourceValue->ebitda)
        ->and($dashboard['summary']['toc'])->toBe($costBreakdownTotal)
        ->and($firstChild['value_source'])->toBe('excel')
        ->and($firstChild['value']['toc'])->toBe((float) $childSourceValue->toc)
        ->and($firstChild['value']['ebitda'])->toBe((float) $childSourceValue->ebitda);
});

test('dashboard cost alerts flag doc or ioc costs that exceed toc', function () {
    $this->seed(OrganizationSeeder::class);

    $directorate = Organization::query()
        ->where('code', '1.A.3')
        ->firstOrFail();

    EbitdaValue::query()->create([
        'organization_id' => $directorate->id,
        'period_date' => null,
        'year' => 2026,
        'scenario' => EbitdaValue::SCENARIO_TARGET_TAHUNAN,
        'source_sheet' => 'Feature test',
        'revenue' => 0,
        'doc_variable' => 1_500_000,
        'doc_fixed' => 500_000,
        'ioc' => 250_000,
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
        ->and($alert['overrun_amount'])->toBe(500_000.0)
        ->and(collect($alert['overrun_components'])->pluck('key')->all())->toContain('doc_variable');
});
