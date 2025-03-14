<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('GET /api/login returns a 404', function () {
    $response = $this->get('/api/login');
    
    $response->assertStatus(404);
});

test('POST /api/login returns a 404', function () {
    $response = $this->post('/api/login');
    
    $response->assertStatus(404);
});

test('GET /api/register returns a 404', function () {
    $response = $this->get('/api/register');
    
    $response->assertStatus(404);
});

test('POST /api/register returns a 404', function () {
    $response = $this->post('/api/register');
    
    $response->assertStatus(404);
});