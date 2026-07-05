<?php

use App\Models\User;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('import-excel.index'));

    $response->assertRedirect(route('login'));
});

test('authenticated users can visit the import excel page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('import-excel.index'));

    $response->assertOk();
});
