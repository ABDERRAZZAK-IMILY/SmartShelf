<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('GET /api/products returns all products', function () {
    \App\Models\Product::create(['name' => 'Milk', 'price' => 1.99, 'rayon_id' => 1]);

    $response = $this->get('/api/products');
    
    $response->assertStatus(200);
});

test('POST /api/products creates a new product', function () {
    $response = $this->post('/api/products', [
        'name' => 'Bread',
        'price' => 2.99,
        'rayon_id' => 1,
    ], ['Accept' => 'application/json']);
    
    $response->assertStatus(201);
});

test('GET /api/products/{id} returns a specific product', function () {
    $product = \App\Models\Product::create(['name' => 'Milk', 'price' => 1.99, 'rayon_id' => 1]);
    
    $response = $this->get("/api/products/{$product->id}");
    
    $response->assertStatus(200);
});

test('PUT /api/products/{id} updates an existing product', function () {
    $product = \App\Models\Product::create(['name' => 'Old Name', 'price' => 1.99, 'rayon_id' => 1]);
    
    $response = $this->put("/api/products/{$product->id}", [
        'name' => 'Updated Name',
        'price' => 2.99,
        'rayon_id' => 1,
    ], ['Accept' => 'application/json']);
    
    $response->assertStatus(200);
});

test('DELETE /api/products/{id} deletes a product', function () {
    $product = \App\Models\Product::create(['name' => 'Milk', 'price' => 1.99, 'rayon_id' => 1]);
    
    $response = $this->delete("/api/products/{$product->id}", [], ['Accept' => 'application/json']);
    
    $response->assertStatus(204);
    $this->assertDatabaseMissing('products', ['id' => $product->id]);
});