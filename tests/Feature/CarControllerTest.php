<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Car;
use App\Models\Brand;
use App\Models\Categorie;
use App\Models\User;

class CarControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->brand = Brand::factory()->create(['name' => 'Toyota']);
        $this->categorie = Categorie::factory()->create(['name' => 'SUV']);
    }

    public function test_can_create_car()
    {
        $response = $this->postJson('/api/auth/car/create', [
            'name' => 'Camry',
            'year' => 2023,
            'color' => 'Blue',
            'price' => 25000,
            'chassisNumber' => 'ABC123456789',
            'description' => 'Great car',
            'categorie_id' => $this->categorie->id,
            'brand_id' => $this->brand->id
        ]);

        $response->assertStatus(201)
                ->assertJson(['message' => 'Car added successfully']);
    }

    public function test_cannot_create_car_with_invalid_data()
    {
        $response = $this->postJson('/api/auth/car/create', [
            'name' => '',
            'year' => 1800,
            'price' => -100
        ]);

        $response->assertStatus(422)
                ->assertJsonStructure(['errors']);
    }

    public function test_can_get_all_cars()
    {
        Car::factory()->count(3)->create([
            'brand_id' => $this->brand->id,
            'categorie_id' => $this->categorie->id
        ]);

        $response = $this->getJson('/api/auth/cars');

        $response->assertStatus(200)
                ->assertJsonCount(3);
    }

    public function test_can_get_car_by_id()
    {
        $car = Car::factory()->create([
            'brand_id' => $this->brand->id,
            'categorie_id' => $this->categorie->id
        ]);

        $response = $this->getJson('/api/auth/car/' . $car->id);

        $response->assertStatus(200)
                ->assertJsonStructure(['id', 'name', 'category', 'brand']);
    }

    public function test_can_update_car()
    {
        $car = Car::factory()->create([
            'brand_id' => $this->brand->id,
            'categorie_id' => $this->categorie->id
        ]);

        $response = $this->putJson('/api/auth/car/' . $car->id, [
            'id' => $car->id,
            'name' => 'Updated Car',
            'year' => 2024,
            'color' => 'Red',
            'price' => 30000,
            'chassisNumber' => 'XYZ987654321',
            'description' => 'Updated description',
            'categorie_id' => $this->categorie->id,
            'brand_id' => $this->brand->id
        ]);

        $response->assertStatus(200)
                ->assertJson(['message' => 'Car updated successfully']);
    }

    public function test_can_delete_car()
    {
        $car = Car::factory()->create([
            'brand_id' => $this->brand->id,
            'categorie_id' => $this->categorie->id
        ]);

        $response = $this->deleteJson('/api/auth/car/' . $car->id, [
            'id' => $car->id
        ]);

        $response->assertStatus(200)
                ->assertJson(['message' => 'Car deleted successfully']);
    }

    public function test_can_search_cars_by_name()
    {
        Car::factory()->create([
            'name' => 'Toyota Camry',
            'brand_id' => $this->brand->id,
            'categorie_id' => $this->categorie->id
        ]);

        $response = $this->getJson('/api/auth/cars/search?name=Camry');

        $response->assertStatus(200)
                ->assertJsonCount(1);
    }
}