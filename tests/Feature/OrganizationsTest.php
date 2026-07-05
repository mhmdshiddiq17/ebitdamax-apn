<?php

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
