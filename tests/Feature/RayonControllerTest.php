
<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('GET /api/rayons returns all rayons', function () {
    \App\Models\Rayon::create(['name' => 'Dairy Section', 'description' => 'Section for dairy products']);

    $response = $this->get('/api/rayons');
    
    $response->assertStatus(200);
});

test('POST /api/rayons creates a new rayon', function () {
    $response = $this->post('/api/rayons', [
        'name' => 'Bakery Section',
        'description' => 'Section for bread and pastries',
    ], ['Accept' => 'application/json']);
    
    $response->assertStatus(201);
});

test('GET /api/rayons/{id} returns a specific rayon', function () {
    $rayon = \App\Models\Rayon::create(['name' => 'Dairy Section', 'description' => 'Section for dairy products']);
    
    $response = $this->get("/api/rayons/{$rayon->id}");
    
    $response->assertStatus(200);
});

test('PUT /api/rayons/{id} updates an existing rayon', function () {
    $rayon = \App\Models\Rayon::create(['name' => 'Old Name', 'description' => 'Old description']);
    
    $response = $this->put("/api/rayons/{$rayon->id}", [
        'name' => 'Updated Name',
        'description' => 'Updated description',
    ], ['Accept' => 'application/json']);
    
    $response->assertStatus(200);
});

test('DELETE /api/rayons/{id} deletes a rayon', function () {
    $rayon = \App\Models\Rayon::create(['name' => 'Dairy Section', 'description' => 'Section for dairy products']);
    
    $response = $this->delete("/api/rayons/{$rayon->id}", [], ['Accept' => 'application/json']);
    
    $response->assertStatus(204);
    $this->assertDatabaseMissing('rayons', ['id' => $rayon->id]);
});
