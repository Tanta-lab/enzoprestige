<?php

test('admin can create product', function () {

    $user = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($user)->post('/admin/products', [
        'name' => 'Produit test',
        'description' => 'test',
        'price' => 10,
        'stock' => 5
    ]);

    $response->assertRedirect();

    $this->assertDatabaseHas('products', [
        'name' => 'Produit test'
    ]);

});
