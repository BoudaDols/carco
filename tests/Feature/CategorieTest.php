<?php

namespace Tests\Feature;

use App\Models\Car;
use App\Models\User;
use App\Models\Categorie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategorieTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_user_can_add_a_categorie()
    {
        $categorieData = [
            'name' => 'Test Categorie',
        ];

        $response = $this->actingAs($this->user, 'sanctum')->postJson('/api/auth/categories', $categorieData);

        $response->assertStatus(201)
            ->assertJsonFragment($categorieData);

        $this->assertDatabaseHas('categories', $categorieData);
    }

    public function test_user_can_get_all_categories()
    {
        Categorie::factory()->count(3)->create();

        $response = $this->actingAs($this->user, 'sanctum')->getJson('/api/auth/categories');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_user_can_get_a_categorie_by_id()
    {
        $categorie = Categorie::factory()->create();

        $response = $this->actingAs($this->user, 'sanctum')->getJson("/api/auth/categories/{$categorie->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $categorie->name]);
    }

    public function test_user_can_update_a_categorie()
    {
        $categorie = Categorie::factory()->create();

        $updatedData = [
            'name' => 'Updated Categorie Name',
        ];

        $response = $this->actingAs($this->user, 'sanctum')->putJson("/api/auth/categories/{$categorie->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment($updatedData);

        $this->assertDatabaseHas('categories', $updatedData);
    }

    public function test_user_can_delete_a_categorie()
    {
        $categorie = Categorie::factory()->create();

        $response = $this->actingAs($this->user, 'sanctum')->deleteJson("/api/auth/categories/{$categorie->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('categories', ['id' => $categorie->id]);
    }

    public function test_user_can_get_cars_by_categorie()
    {
        $categorie = Categorie::factory()->create();
        Car::factory()->count(3)->create(['categorie_id' => $categorie->id]);

        $response = $this->actingAs($this->user, 'sanctum')->getJson("/api/auth/categories/{$categorie->id}/cars");

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }
}
