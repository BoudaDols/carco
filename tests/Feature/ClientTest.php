<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use RefreshDatabase;
    use \Illuminate\Foundation\Testing\WithFaker;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_user_can_add_a_client()
    {
        $clientData = [
            'name' => 'Test Client',
            'dateNaissance' => $this->faker->date(),
            'sexe' => 'M',
            'domaineP' => $this->faker->word(),
        ];

        $response = $this->actingAs($this->user, 'sanctum')->postJson('/api/auth/client', $clientData);

        $response->assertStatus(201)
            ->assertJsonFragment($clientData);

        $this->assertDatabaseHas('clients', $clientData);
    }

    public function test_user_can_get_all_clients()
    {
        Client::factory()->count(3)->create();

        $response = $this->actingAs($this->user, 'sanctum')->getJson('/api/auth/clients');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_user_can_get_a_client_by_id()
    {
        $client = Client::factory()->create();

        $response = $this->actingAs($this->user, 'sanctum')->getJson("/api/auth/client/{$client->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $client->name]);
    }

    public function test_user_can_update_a_client()
    {
        $client = Client::factory()->create();

        $updatedData = [
            'name' => 'Updated Client Name',
        ];

        $response = $this->actingAs($this->user, 'sanctum')->putJson("/api/auth/client/{$client->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment($updatedData);

        $this->assertDatabaseHas('clients', $updatedData);
    }

    public function test_user_can_delete_a_client()
    {
        $client = Client::factory()->create();

        $response = $this->actingAs($this->user, 'sanctum')->deleteJson("/api/auth/client/{$client->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }
}