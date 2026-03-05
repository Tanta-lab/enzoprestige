<?php

use App\Models\User;

test('admin can access admin products', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->get('/admin/products')
        ->assertOk();
});

test('non admin is forbidden from admin products', function () {
    $user = User::factory()->create(['role' => 'user']);

    $this->actingAs($user)
        ->get('/admin/products')
        ->assertForbidden();
});
