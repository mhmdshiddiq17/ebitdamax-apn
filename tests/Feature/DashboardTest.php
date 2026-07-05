<?php

use Database\Seeders\OrganizationSeeder;
use Inertia\Testing\AssertableInertia as Assert;
use App\Models\User;

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
            ->where('directorates.0.code', '1.C')
            ->where('directorates.0.name', 'Corporate Secretary, Legal, Internal Audit, Pengamanan, Information Technology')
        );
});
