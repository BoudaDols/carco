<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApiTest extends TestCase
{
    public function test_api_welcome_endpoint()
    {
        $response = $this->getJson('/api/');

        $response->assertStatus(200)
                ->assertJson(['message' => 'Welcome to the API CarCo!']);
    }

    public function test_api_returns_json()
    {
        $response = $this->getJson('/api/');

        $response->assertHeader('Content-Type', 'application/json');
    }
}