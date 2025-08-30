<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Car;
use App\Models\Categorie;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_user_can_add_a_car()
    {
        $brand = Brand::factory()->create();
        $categorie = Categorie::factory()->create();

        $carData = [
            'name' => 'Test Car',
            'description' => 'This is a test car.',
            'price' => 10000,
            'image' => 'test.jpg',
            'brand_id' => $brand->id,
            'categorie_id' => $categorie->id,
        ];

        $response = $this->actingAs($this->user, 'sanctum')->postJson('/api/auth/cars', $carData);

        $response->assertStatus(201)
            ->assertJsonFragment($carData);

        $this->assertDatabaseHas('cars', $carData);
    }

    public function test_user_can_get_all_cars()
    {
        Car::factory()->count(3)->create();

        $response = $this->actingAs($this->user, 'sanctum')->getJson('/api/auth/cars');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    public function test_user_can_get_a_car_by_id()
    {
        $car = Car::factory()->create();

        $response = $this->actingAs($this->user, 'sanctum')->getJson("/api/auth/cars/{$car->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $car->name]);
    }

    public function test_user_can_update_a_car()
    {
        $car = Car::factory()->create();

        $updatedData = [
            'name' => 'Updated Car Name',
            'price' => 15000,
            'description' => 'Updated car description',
            'color' => 'Blue',
            'chassisNumber' => 'ABC123',
            'year' => 2022,
            'brand_id' => $car->brand_id,
            'categorie_id' => $car->categorie_id,
        ];

        $response = $this->actingAs($this->user, 'sanctum')->putJson("/api/auth/cars/{$car->id}", $updatedData);

        $response->assertStatus(200)
            ->assertJsonFragment($updatedData);

        $this->assertDatabaseHas('cars', $updatedData);
    }

    public function test_user_can_delete_a_car()
    {
        $car = Car::factory()->create();

        $response = $this->actingAs($this->user, 'sanctum')->deleteJson("/api/auth/cars/{$car->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('cars', ['id' => $car->id]);
    }
}