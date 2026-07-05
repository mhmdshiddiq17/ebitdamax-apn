<?php

use App\Models\Organization;
use App\Models\User;

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
