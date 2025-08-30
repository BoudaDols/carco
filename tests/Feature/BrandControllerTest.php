<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Brand;
use App\Models\Car;
use App\Models\Categorie;

class BrandControllerTest extends TestCase
{
    public function test_can_get_all_brands()
    {
        Brand::factory()->count(3)->create();

        $response = $this->getJson('/api/auth/brands');

        $response->assertStatus(200);
    }

    public function test_can_create_brand()
    {
        $response = $this->postJson('/api/auth/brand/create', [
            'name' => 'Toyota',
            'origin' => 'Japan'
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('brands', ['name' => 'Toyota']);
    }

    public function test_cannot_create_duplicate_brand()
    {
        Brand::factory()->create(['name' => 'Toyota']);

        $response = $this->postJson('/api/auth/brand/create', [
            'name' => 'Toyota',
            'origin' => 'Japan'
        ]);

        $response->assertStatus(422);
    }

    public function test_can_update_brand()
    {
        $brand = Brand::factory()->create();

        $response = $this->putJson('/api/auth/brand/' . $brand->id, [
            'name' => 'Updated Brand',
            'origin' => 'Updated Origin'
        ]);

        $response->assertStatus(200);
    }

    public function test_can_delete_brand()
    {
        $brand = Brand::factory()->create();

        $response = $this->deleteJson('/api/auth/brand/' . $brand->id);

        $response->assertStatus(200)
                ->assertJson(['message' => 'Brand deleted successfully']);
    }

    public function test_can_get_cars_by_brand()
    {
        $brand = Brand::factory()->create(['name' => 'Toyota']);
        $categorie = Categorie::factory()->create();
        
        Car::factory()->count(2)->create([
            'brand_id' => $brand->id,
            'categorie_id' => $categorie->id
        ]);

        $response = $this->getJson('/api/auth/brands/cars?name=Toyota');

        $response->assertStatus(200)
                ->assertJsonCount(2);
    }
}