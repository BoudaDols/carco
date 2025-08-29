<?php

namespace Tests\Feature;

use App\Models\Achat;
use App\Models\User;
use App\Models\Car;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AchatTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_user_can_add_an_achat()
    {
        $car = Car::factory()->create();
        $client = Client::factory()->create();

        $achatData = [
            'car_id' => $car->id,
            'client_id' => $client->id,
        ];

        $response = $this->actingAs($this->user, 'sanctum')->postJson('/api/auth/achat', $achatData);

        $response->assertStatus(201)
            ->assertJsonFragment($achatData);

        $this->assertDatabaseHas('achats', $achatData);
    }

    public function test_user_can_get_all_achats()
    {
        Achat::factory()->count(3)->create();

        $response = $this->actingAs($this->user, 'sanctum')->getJson('/api/auth/achats');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_user_can_get_an_achat_by_id()
    {
        $achat = Achat::factory()->create();

        $response = $this->actingAs($this->user, 'sanctum')->getJson("/api/auth/achat/{$achat->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['car_id' => $achat->car_id, 'client_id' => $achat->client_id]);
    }

    public function test_user_can_update_an_achat()
    {
        $achat = Achat::factory()->create();

        $updatedData = [
            'car_id' => $achat->car_id,
            'client_id' => $achat->client_id,
        ];

        $response = $this->actingAs($this->user, 'sanctum')->putJson("/api/auth/achat/{$achat->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment($updatedData);

        $this->assertDatabaseHas('achats', $updatedData);
    }

    public function test_user_can_delete_an_achat()
    {
        $achat = Achat::factory()->create();

        $response = $this->actingAs($this->user, 'sanctum')->deleteJson("/api/auth/achat/{$achat->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('achats', ['id' => $achat->id]);
    }
}