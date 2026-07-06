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

test('directorate dashboard charts use the same rollup values as the tree breakdown', function () {
    $this->seed(OrganizationSeeder::class);
    $this->seed(OrganizationCalculationSeeder::class);
    $this->seed(EbitdaValueSeeder::class);

    $directorate = Organization::query()
        ->where('code', '1.A.3')
        ->firstOrFail();

    $dashboard = app(EbitdaDashboardService::class)->directorateDashboard(
        $directorate,
        2026,
        EbitdaValue::SCENARIO_TARGET_TAHUNAN
    );

    $childValues = array_column($dashboard['tree']['children'], 'value');
    $costBreakdownTotal = array_sum(array_column($dashboard['charts']['cost_breakdown'], 'value'));

    expect($dashboard['tree']['value_source'])->toBe('calculated_from_children')
        ->and($dashboard['summary']['toc'])->toBe($costBreakdownTotal)
        ->and($dashboard['summary']['ebitda'])->toBe(array_sum(array_column($childValues, 'ebitda')))
        ->and(array_sum(array_column($dashboard['charts']['ebitda_by_directorate'], 'value')))->toBe(array_sum(array_column($childValues, 'ebitda')));
});
